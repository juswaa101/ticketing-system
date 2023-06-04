<div class="col py-3">
    <div class="row p-3">
        <h1 class="text-justify fw-bold">Account Verification</h1>
        <div class="mx-1">
            @include('components.alerts.success')
        </div>
    </div>
    <div class="row p-3">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <p class="text-justify lead">
                        Thanks for Signing Up! Before getting started, could your verify your email address by clicking
                        on the link we just emailed to you? If you didn't receive the email, we will gladly send you
                        another.
                    </p>
                </div>
                <div class="card-footer">
                    <form action="{{ route('resend.verify') }}" method="post" class="btn">
                        @csrf
                        <button class="btn btn-primary" type="submit">Verify</button>
                    </form>
                    <a class="btn btn-secondary" href="{{ route('logout') }}">Logout</a>
                </div>
            </div>
        </div>
    </div>
</div>
