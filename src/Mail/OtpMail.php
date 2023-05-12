<?php

namespace Putuariepra\SimpleOtp\Mail;

use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Putuariepra\SimpleOtp\NewSimpleOtpToken;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;    
    public $token_validity_minutes;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(NewSimpleOtpToken $token, Request $request)
    {        
        $this->token = $token;        
        $this->token_validity_minutes = config('otp.token_validity_minutes', 30);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(__(':Name One-time Password (OTP)', ['name' => config('app.name')]))
        ->markdown('simpleotp::mail')
        ->with([
            'token' => $this->token,
            'token_validity_minutes' => $this->token_validity_minutes,
        ]);
    }
}
