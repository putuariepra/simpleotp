<?php

namespace Putuariepra\SimpleOtp\Interfaces\Models;

interface SimpleOtpTokenInterface
{
    function isExpired();

    function isUsed();

    function setUsed();

    function isMaxAttemptsExceeded();
}