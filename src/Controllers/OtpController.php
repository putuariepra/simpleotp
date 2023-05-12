<?php

namespace Putuariepra\SimpleOtp\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Putuariepra\SimpleOtp\SimpleOtp;
use Putuariepra\SimpleOtp\SimpleOtpException;

class OtpController extends Controller
{
    public function index($procedure, Request $request)
    {
      $cls = $this->getProcedure($procedure);

      return $cls->index($request);      
    }

    public function sendPassword($procedure, Request $request, SimpleOtp $otp)
    {
      $cls = $this->getProcedure($procedure);      

      if (is_null($cls->config->user_model)) {
        $to = $cls->to();
        $token = $otp->createToken($request->input($to), $procedure);
      }else{
        $cls->validatorSend($request->all(), $cls->config->user_model)->validate();
  
        $user = $cls->config->user_model::find($request->input('id'));
  
        $to = $cls->to();
        $token = $otp->createTokenWithUser($user, $user->$to, $procedure);
      }

      return $cls->send($token, $request);
    }

    public function requestPassword($procedure, $token, SimpleOtp $otp)
    {
      $cls = $this->getProcedure($procedure);

      $token = $otp->getToken($procedure, $token);
      
      $this->checkToken($cls, $token);
      
      return view("simpleotp::request", compact('procedure', 'token'));
    }

    public function verifyPassword($procedure, $token, Request $request, SimpleOtp $otp)
    {
      $cls = $this->getProcedure($procedure);      

      $token = $otp->getToken($procedure, $token);

      $this->checkToken($cls, $token);
      
      if ($otp->verifyToken($token, $request->input('otp_password'))) {
        $token->setUsed()->save();
        return $cls->authenticated($token);        
      }else{
        return $cls->unauthenticated($token);        
      }
    }

    private function getProcedure($procedure)
    {
      $procedures = config('otp.procedures', []);
      if (!isset($procedures[$procedure])) {
        \abort(404);
      }

      return $this->newChannelClass($procedure, $procedures[$procedure]);
    }

    private function newChannelClass($procedure, $cnf_procedure)
    {
      $cls = new $cnf_procedure['class'];
      $cls->procedure = $procedure;
      $cls->config = (object) $cnf_procedure;
      
      return $cls;
    }
    
    private function checkToken($cls, $token)
    {
      if (empty($token->id)) {
        throw new SimpleOtpException($cls, "tokenNotFound");
      }

      if ($token->isExpired()) {
        throw new SimpleOtpException($cls, "tokenExpired");
      }

      if ($token->isUsed()) {                
        throw new SimpleOtpException($cls, "tokenUsed");
      }
    }
}
