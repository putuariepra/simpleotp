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
      $cnf_procedure = $this->getProcedure($procedure);

      $cls = new $cnf_procedure['class'];

      return $cls->index($request);      
    }

    public function sendPassword($procedure, Request $request, SimpleOtp $otp)
    {
      $cnf_procedure = $this->getProcedure($procedure);      

      $cls = new $cnf_procedure['class'];
      
      $cls->validatorSend($request->all(), $cnf_procedure['user_model'])->validate();

      $user = $cnf_procedure['user_model']::find($request->input('id'));

      $to = $cls->to();
      $token = $otp->createToken($user, $user->$to, $procedure);

      return $cls->send($token, $request);
    }

    public function requestPassword($procedure, $token, SimpleOtp $otp)
    {
      $cnf_procedure = $this->getProcedure($procedure);      

      $cls = new $cnf_procedure['class'];           
      
      $token = $otp->getToken($procedure, $token);
      
      $this->checkToken($cls, $token);
      
      return view("simpleotp::request", compact('procedure', 'token'));
    }

    public function verifyPassword($procedure, $token, Request $request, SimpleOtp $otp)
    {
      $cnf_procedure = $this->getProcedure($procedure);      

      $cls = new $cnf_procedure['class'];           
      
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

      return $procedures[$procedure];      
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
