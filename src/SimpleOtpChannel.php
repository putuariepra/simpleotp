<?php

namespace Putuariepra\SimpleOtp;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Putuariepra\SimpleOtp\NewSimpleOtpToken;
use Putuariepra\SimpleOtp\SimpleOtpChannelInterface;

class SimpleOtpChannel implements SimpleOtpChannelInterface
{
    function index(Request $request)
    {
        return view('simpleotp::index');        
    }

    function send(NewSimpleOtpToken $token, Request $request)
    {
        
    }    

    function validatorSend(array $data, $user_model)
    {
        return Validator::make($data, [
        ]);
    }

    function tokenNotFound()
    {        
        return view('simpleotp::errors.notfound');
    }

    function tokenExpired()
    {
        return view('simpleotp::errors.expired');
    }

    function tokenUsed()
    {        
        return view('simpleotp::errors.used');
    }

    function to()
    {
        return 'email';
    }

    function authenticated($token)
    {
        
    }

    function unauthenticated($token)
    {
        
    }
}