@if ($errors->any())
    <ul>        
        @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
        @endforeach
    </ul>
@endif

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

@if (session()->has('error'))
    @if(is_array(session('error')))
        <ul>
            @foreach (session('error') as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    @else
        {{ session('error') }}
    @endif
@endif

<form action="/otp/{{$procedure}}/{{$token->token}}" method="POST">
    @csrf

    <input type="text" name="otp_password" value="">
    <button type="submit">submit</button>
</form>