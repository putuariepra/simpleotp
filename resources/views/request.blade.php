<form action="/otp/{{$procedure}}/{{$token->token}}" method="POST">
    @csrf

    <input type="text" name="otp_password" value="">
    <button type="submit">submit</button>
</form>