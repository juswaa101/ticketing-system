<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('cdn.bootstrap')
    @include('cdn.google-fonts')
    <title>Ticketing System - Register</title>
</head>

<body>
    @include('partials.navbar')
    <div class="container">
        <div class="row my-5">
            <div class="col-md-6 mx-auto">
                <h1 class="text-center fw-bold">
                    Register Account
                </h1>
                <div class="card mt-3 mb-5">
                    <div class="card-header">
                        <small class="text-muted">Create an account to proceed</small>
                    </div>
                    <form method="post" action="{{ route('register.auth') }}">
                        @csrf
                        <div class="card-body">
                            @include('components.alerts.success')
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" placeholder="Juan Dela Cruz"
                                    value="{{ old('name') }}">
                                <label for="floatingInput">Full Name</label>
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" placeholder="name@example.com"
                                    value="{{ old('email') }}">
                                <label for="floatingInput">Email address</label>
                                @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" placeholder="Password" name="password">
                                <label for="floatingPassword">Password</label>
                                @error('password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-floating">
                                <input type="password"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    id="password" placeholder="Confirm Password" name="password_confirmation">
                                <label for="floatingPassword">Confirm Password</label>
                                @error('password_confirmation')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary btn-md" type="submit">Register</button>
                            <a href="{{ route('login') }}" class="text-decoration-none float-end mt-2"> Click here</a>
                            <a class="text-dark text-decoration-none float-end mt-2 mx-2">Already have an account? </a>
                            &nbsp;
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('partials.footer')

    @include('cdn.popper-js')
</body>

</html>
