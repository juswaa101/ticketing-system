@if (Session::has('error'))
    <div class="alert alert-danger">
        <h6>{{ Session::get('error') }}</h6>
    </div>
@endif
