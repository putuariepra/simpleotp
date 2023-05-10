<?php
namespace Putuariepra\SimpleOtp\Channels;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Putuariepra\SimpleOtp\SimpleOtpChannel;
use Putuariepra\SimpleOtp\NewSimpleOtpToken;

class OtpEmail extends SimpleOtpChannel {    
    function send(NewSimpleOtpToken $token, Request $request)
    {
        dd($token);
    }

    function validatorSend(array $data, $user_model)
    {
        return Validator::make($data, [            
            'id' => ['required', 'string', 'exists:'.$user_model],
            'to' => ['required', 'string'],
        ]);
    }

    function authenticated($token)
    {
        dd($token);
    }

    function unauthenticated($token)
    {
        dd($token);
    }
}