<div class="col py-3">
    <div class="row p-3">
        <h1 class="text-justify fw-bold">Account Settings</h1>
    </div>
    <div class="row p-3">
        <div class="col-md-4 mx-auto">
            <div class="text-center">
                <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=0D8ABC&color=fff"
                    width="200" height="200" class="rounded-circle text-center mb-3">
            </div>
            @include('components.alerts.success')
            <form method="POST" action="{{ route('settings.update') }}">
                @method('PUT')
                @csrf
                <label for="name" class="mt-3">Name: </label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Full Name"
                    value="{{ auth()->user()->name }}" name="name">
                @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
                <label for="email" class="mt-3">Email: </label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email"
                    value="{{ auth()->user()->email }}" name="email">
                @error('email')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
                <label for="password" class="mt-3">New Password: </label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password"
                    name="password">
                @error('password')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
                <label for="password_confirmation" class="mt-3">New Password Confirmation: </label>
                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                    placeholder="Confirm Password" name="password_confirmation">
                @error('password_confirmation')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
                <label for="role_type" class="mt-3">Role: </label>
                <br />
                @forelse (auth()->user()->roles as $role)
                    <span class="badge rounded-pill bg-success">{{ Str::upper($role->role_name) }}</span>
                @empty
                    <span class="badge rounded-pill bg-danger">No Assigned Role Yet</span>
                @endforelse
                <br />
                <button type="submit" class="mt-3 btn btn-primary btn-md">Update</button>
                <a class="mt-3 btn btn-secondary btn-md"
                    href="@can('admin') {{ route('admin.dashboard') }} @else {{ route('user.dashboard') }} @endcan">Back</a>
            </form>
        </div>
    </div>
</div>
