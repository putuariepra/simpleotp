@if ($errors->any())
    <ul>        
        @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
        @endforeach
    </ul>
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

<form method='POST'>
    {{csrf_field()}}    
    <input name='to' value='' placeholder="To">
    <button type='submit'>Submit</button>
</form>