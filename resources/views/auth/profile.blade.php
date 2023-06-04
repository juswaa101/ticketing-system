<div class="col py-3">
    <div class="row p-3">
        <h1 class="text-justify fw-bold">Profile</h1>
    </div>
    <div class="row p-3">
        <div class="col-md-4 mx-auto">
            <div class="text-center">
                <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=0D8ABC&color=fff"
                    width="200" height="200" class="rounded-circle text-center">
            </div>
            <label for="name" class="mt-3">Name: </label>
            <input type="text" class="form-control" value="{{ auth()->user()->name }}" disabled>
            <label for="email" class="mt-3">Email: </label>
            <input type="email" class="form-control" value="{{ auth()->user()->email }}" disabled>
            <label for="role_type" class="mt-3">Role: </label>
            <br />
            @forelse (auth()->user()->roles as $role)
                <span class="badge rounded-pill bg-success">{{ Str::upper($role->role_name) }}</span>
            @empty
                <span class="badge rounded-pill bg-danger">No Assigned Role Yet</span>
            @endforelse
            <br />
            <a class="mt-3 btn btn-secondary btn-md"
                href="@can('admin') {{ route('admin.dashboard') }} @else {{ route('user.dashboard') }} @endcan">Back</a>
        </div>
    </div>
</div>
