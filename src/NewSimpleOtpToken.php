<?php

namespace Putuariepra\SimpleOtp;

use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use Putuariepra\SimpleOtp\Models\SimpleOtpToken;

class NewSimpleOtpToken implements Arrayable, Jsonable
{    
    public $token;
 
    public $plainTextPassword;

    public function __construct(SimpleOtpToken $token, string $plainTextPassword)
    {
        $this->token = $token;
        $this->plainTextPassword = $plainTextPassword;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'token' => $this->token,
            'plainTextPassword' => $this->plainTextPassword,
        ];
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int  $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }
}
