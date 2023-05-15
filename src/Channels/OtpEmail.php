<?php
namespace Putuariepra\SimpleOtp\Channels;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Putuariepra\SimpleOtp\Mail\OtpMail;
use Illuminate\Support\Facades\Validator;
use Putuariepra\SimpleOtp\SimpleOtpChannel;
use Putuariepra\SimpleOtp\NewSimpleOtpToken;

class OtpEmail extends SimpleOtpChannel {
    function send(NewSimpleOtpToken $token, Request $request)
    {    
        try {
            $email = $request->input('to');

            $gg = Mail::to($email)->send(new OtpMail($token, $request));
            
            return $this->sendSuccessed($token, $request);
        } catch (\Exception $e) {
            return $this->sendFailed($token, $request, $e);
        }
    }

    function sendSuccessed(NewSimpleOtpToken $token, Request $request)
    {
        return redirect()->route('otp.request', ['procedure' => $this->procedure, 'token' => $token->token->token])->with('success', __('One-time Password (OTP) send successfully.'));
    }

    function sendFailed(NewSimpleOtpToken $token, Request $request, \Exception $e)
    {
        return redirect()->back()->with('error', $e->getMessage());
    }

    function validatorSend(array $data, $user_model)
    {
        return Validator::make($data, [
            'to' => ['required', 'string', 'email'],
        ]);
    }

    function to()
    {
        return 'to';
    }

    function authenticated($token)
    {
        
    }

    function unauthenticated($token)
    {
        if (!$token->isMaxAttemptsExceeded()) {
            return redirect()->back()->with('error', 'OTP Password is incorrect.');
        }
    }
}