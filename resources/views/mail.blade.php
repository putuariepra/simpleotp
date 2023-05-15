@component('mail::message')
    <div>
        {{ __('Bellow is your one-time password (OTP).') }}
        <br><br>
        <strong>{{ $token->plainTextPassword }}</strong>
        <br>
        <em>{{ __('The OTP will expire in :token_validity_minutes minutes.', ['token_validity_minutes' => $token_validity_minutes]) }}</em>
        <br><br>
        {{ __('Please maintain confidentiality and immediately use the OTP above to continue the access rights process.') }}
    </div>
@endcomponent