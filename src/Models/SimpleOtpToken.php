<?php

namespace Putuariepra\SimpleOtp\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Putuariepra\SimpleOtp\Interfaces\Models\SimpleOtpTokenInterface;

class SimpleOtpToken extends Model implements SimpleOtpTokenInterface
{
    protected $fillable = [
        'procedure',
        'to',
        'token',
        'password',
        'attempt_counter',
        'used_at',
        'expired_at'
    ];

    protected $casts = [
        'used_at' => 'datetime',
        'expired_at' => 'datetime',
    ];

    function isExpired() {        
        return $this->expired_at->lt(Carbon::now());
    }

    function isUsed() {        
        return !is_null($this->used_at);
    }

    function setUsed() {        
        $this->used_at = Carbon::now();
        return $this;
    }

    function isMaxAttemptsExceeded() {
        return $this->attempt_counter >= config('otp.max_attempts', 5);
    }
}
