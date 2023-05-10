<?php

namespace Putuariepra\SimpleOtp;

use Illuminate\Http\Request;
use Putuariepra\SimpleOtp\NewSimpleOtpToken;

interface SimpleOtpChannelInterface
{
    function index(Request $request);
    
    function send(NewSimpleOtpToken $token, Request $request);

    function validatorSend(array $data, $user_model);

    function tokenNotFound();

    function tokenExpired();

    function tokenUsed();

    function to();

    function authenticated($token);

    function unauthenticated($token);
}