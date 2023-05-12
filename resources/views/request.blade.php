@if (session()->has('success'))
    @if(is_array(session('success')))
        <ul>
            @foreach (session('success') as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    @else
        {{ session('success') }}
    @endif
@endif

<form action="/otp/{{$procedure}}/{{$token->token}}" method="POST">
    @csrf

    <input type="text" name="otp_password" value="">
    <button type="submit">submit</button>
</form>