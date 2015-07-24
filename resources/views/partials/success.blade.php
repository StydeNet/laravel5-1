@if(Session::has('alert'))
    <p class="alert alert-success">
        {{ Session::get('alert') }}
    </p>
@endif