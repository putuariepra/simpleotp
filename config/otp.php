<?php

return [
    'procedures' => [
        'mailuser' => [
            'class' => \Putuariepra\SimpleOtp\Channels\OtpEmail::class,
            'user_model' => \App\Models\User::class,
        ],
        'smsuser' => [
            'class' => \Putuariepra\SimpleOtp\Channels\OtpEmail::class,
            'user_model' => \App\Models\User::class,
        ],        
    ],
    'otp_model' => \Putuariepra\SimpleOtp\Models\SimpleOtpToken::class,
    'otp_model_key' => 'otpable',
    'token_validity_minutes' => 30,
];
