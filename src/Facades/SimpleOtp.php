<?php

namespace Putuariepra\SimpleOtp\Facades;

use Illuminate\Support\Facades\Facade;

class SimpleOtp extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Putuariepra\SimpleOtp\SimpleOtp::class;
    }
}
