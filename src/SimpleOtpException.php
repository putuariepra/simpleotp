<?php

namespace Putuariepra\SimpleOtp;

use Exception;
use Illuminate\Http\Request;

class SimpleOtpException extends Exception
{
    private $channel;
    private $func;

    function __construct($channel, $func) {
        $this->channel = $channel;
        $this->func = $func;
    }

    public function render(Request $request)
    {
        $func = $this->func;
        return $this->channel->$func($request);
    }
}