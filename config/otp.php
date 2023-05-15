<?php

return [
    'procedures' => [
        'mailuser' => [
            'class' => \Putuariepra\SimpleOtp\Channels\OtpEmail::class,
            'user_model' => null,
        ],        
    ],
    'otp_model' => \Putuariepra\SimpleOtp\Models\SimpleOtpToken::class,
    'otp_model_key' => 'otpable',
    'token_validity_minutes' => 30,
    'max_attempts' => 5,
    'max_sends' => [
        'sends' => 3,
        'per_minutes' => 60,
    ],
];
