@if ($errors->any())
    <ul>        
        @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
        @endforeach
    </ul>
@endif

<form method='POST'>
    {{csrf_field()}}
    <input name='id' value='' placeholder="User ID">
    <input name='to' value='' placeholder="To">
    <button type='submit'>Submit</button>
</form>