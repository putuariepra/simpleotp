<?php

namespace Putuariepra\SimpleOtp\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;

trait HasSimpleOtp
{            
    public function simpleOtp()
    {
        return $this->morphMany(config('otp.otp_model'), config('otp.otp_model_key'));
    }
    
    public function createSimpleOtp(string $to, string $password, int $mins, string $procedure)
    {
        return $this->simpleOtp()->create([
            'procedure' => $procedure,
            'to' => $to,
            'token' => Str::lower(Str::random(40)),
            'password' => $password,
            'expired_at' => Carbon::now()->addMinutes($mins),
        ]);
    }    
}
