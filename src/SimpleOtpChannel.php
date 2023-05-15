<?php

namespace Putuariepra\SimpleOtp;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Putuariepra\SimpleOtp\NewSimpleOtpToken;
use Putuariepra\SimpleOtp\Interfaces\Channels\SimpleOtpChannelInterface;

class SimpleOtpChannel implements SimpleOtpChannelInterface
{
    public $procedure;
    public $config;

    function index(Request $request)
    {
        return view('simpleotp::index');        
    }

    function send(NewSimpleOtpToken $token, Request $request) { }

    function maxCreateTokenExceeded()
    {
        return view('simpleotp::errors.maxcreatetoken');
    }

    function validatorSend(array $data, $user_model)
    {
        return Validator::make($data, [
            'to' => ['required', 'string', 'email'],
        ]);
    }

    function validatorVerify(array $data, $user_model)
    {
        return Validator::make($data, [
            'otp_password' => ['required', 'string'],
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

    function tokenMaxAttemptsExceeded()
    {
        return view('simpleotp::errors.attemptsexceeded');
    }

    function to()
    {
        return 'to';
    }

    function authenticated($token) { }

    function unauthenticated($token) { }
}