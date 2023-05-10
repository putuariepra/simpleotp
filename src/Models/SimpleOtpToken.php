<?php

namespace Putuariepra\SimpleOtp\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SimpleOtpToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'procedure',
        'to',
        'token',
        'password',
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
}
