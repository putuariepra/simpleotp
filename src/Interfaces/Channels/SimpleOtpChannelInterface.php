<?php

namespace Putuariepra\SimpleOtp\Interfaces\Channels;

use Illuminate\Http\Request;
use Putuariepra\SimpleOtp\NewSimpleOtpToken;

interface SimpleOtpChannelInterface
{
    function index(Request $request);
    
    function send(NewSimpleOtpToken $token, Request $request);

    function maxCreateTokenExceeded();

    function validatorSend(array $data, $user_model);

    function validatorVerify(array $data, $user_model);

    function tokenNotFound();

    function tokenExpired();

    function tokenUsed();

    function tokenMaxAttemptsExceeded();

    function to();

    function authenticated($token);

    function unauthenticated($token);
}