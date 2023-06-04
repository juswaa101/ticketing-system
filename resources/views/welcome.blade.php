<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('cdn.bootstrap')
    @include('cdn.google-fonts')
    <title>Ticketing System - Home</title>
</head>

<body>
    @include('partials.navbar')

    <div class="container-fluid p-5">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h1 class="text-justify text-center fw-bold p-3">Welcome to Ticketing System</h1>
                    </div>
                    <div class="card-body">
                        <p class="text-justify lead">Welcome to ticketing system, where all issues can be solved by
                            other
                            people who wants to help with your issues or other agendas. You can also help other person
                            whose have issue
                            by solving their issues and monitor issues.
                        </p>
                    </div>
                    <div class="card-footer">
                        <a class="btn btn-primary btn-md" href="{{ route('register') }}">Sign Up</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer')

    @include('cdn.popper-js')
</body>

</html>
