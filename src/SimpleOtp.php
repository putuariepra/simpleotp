<?php
namespace Putuariepra\SimpleOtp;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Putuariepra\SimpleOtp\NewSimpleOtpToken;
use Putuariepra\SimpleOtp\Models\SimpleOtpToken;

class SimpleOtp{

    private $otp_model;

    private $token_validity_minutes;

    private $max_sends;
    private $max_sends_minutes;

    function __construct()
    {
        $otp_model = config('otp.otp_model', SimpleOtpToken::class);
        $this->otp_model = new $otp_model;

        $this->token_validity_minutes = config('otp.token_validity_minutes', 30);

        $this->max_sends = config('otp.max_sends.amount', 3);
        $this->max_sends_minutes = config('otp.max_sends.per_minutes', 60);
    }
    
    function getToken(string $procedure, string $token)
    {        
        return $this->otp_model::where('procedure', $procedure)
        ->where('token', $token)
        ->first();
    }

    function isMaxCreateTokenExceeded(string $to, string $procedure)
    {
        $range_date_check = Carbon::now()->subMinutes($this->max_sends_minutes);
        $count_check = $this->otp_model::where('created_at', '>=', $range_date_check)->whereNull('used_at')->count();

        return $count_check >= $this->max_sends;
    }

    function createToken(string $to, string $procedure)
    {
        $password = rand(100000, (1000000-1));        
        $token = $this->otp_model::create([
            'procedure' => $procedure,
            'to' => $to,
            'token' => Str::lower(Str::random(40)),
            'password' => Hash::make($password),
            'expired_at' => Carbon::now()->addMinutes($this->token_validity_minutes),
        ]);
        
        return new NewSimpleOtpToken($token, $password);
    }

    function createTokenWithUser($user, string $to, string $procedure)
    {
        $password = rand(100000, (1000000-1));        
        $token = $user->createSimpleOtp($to, Hash::make($password), $this->token_validity_minutes, $procedure);
        
        return new NewSimpleOtpToken($token, $password);
    }

    function verifyToken(SimpleOtpToken $token, string $password)
    {
        return Hash::check($password, $token->password);
    }

    public function routes()
    {
        $attributes = [
            'prefix'    => 'otp',
            'as'        => 'otp.',
        ];

        app('router')->group($attributes, function ($router) {
            $router->get('{procedure}', '\Putuariepra\SimpleOtp\Controllers\OtpController@index')->name('index');
            $router->post('{procedure}', '\Putuariepra\SimpleOtp\Controllers\OtpController@sendPassword')->name('send');
            $router->get('{procedure}/{token}', '\Putuariepra\SimpleOtp\Controllers\OtpController@requestPassword')->name('request');
            $router->post('{procedure}/{token}', '\Putuariepra\SimpleOtp\Controllers\OtpController@verifyPassword')->name('verify');
        });
    }
}