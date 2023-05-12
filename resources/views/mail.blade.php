@component('mail::message')
    <div>{{ __('Bellow is your one-time password (OTP).') }}</div>
    <div style="padding: 10px 0;">
        <b>{{ $token->plainTextPassword }}</b>
        <div>{{ __('The OTP will expire in :token_validity_minutes minutes.', ['token_validity_minutes' => $token_validity_minutes]) }}</div>
    </div>
    <div>{{ __('Please maintain confidentiality and immediately use the OTP above to continue the access rights process.') }}</div>
@endcomponent