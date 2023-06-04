<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('cdn.bootstrap')
    @include('cdn.google-fonts')
    <title>Ticketing System - Login</title>
</head>

<body>
    @include('partials.navbar')
    <div class="container">
        <div class="row my-5">
            <div class="col-md-6 mx-auto">
                <h1 class="text-center fw-bold">
                    Login Account
                </h1>
                <div class="card mt-3">
                    <div class="card-header">
                        <small class="text-muted">Login to proceed</small>
                    </div>
                    <form method="post" action="{{ route('login.auth') }}">
                        @csrf
                        <div class="card-body">
                            @include('components.alerts.error')
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" placeholder="name@example.com"
                                    value="{{ old('email') }}">
                                <label for="floatingInput">Email address</label>
                                @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-floating">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" placeholder="Password" name="password">
                                <label for="floatingPassword">Password</label>
                                @error('password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary btn-md" type="submit">Login</button>
                            <a href="{{ route('register') }}" class="text-decoration-none float-end mt-2"> Click here</a>
                            <a class="text-dark text-decoration-none float-end mt-2 mx-2">Dont have an account yet? </a> &nbsp;
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
