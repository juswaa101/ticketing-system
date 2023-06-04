@if (Session::has('success'))
    <div class="alert alert-success">
        <h6>{{ Session::get('success') }}</h6>
    </div>
@endif
