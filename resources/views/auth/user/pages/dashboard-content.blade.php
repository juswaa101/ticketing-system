<style>
    .card {
        padding: 80px;
    }

    .bg {
        background-color: rgb(241, 241, 241);
    }
</style>
<div class="col py-3">
    <div class="row p-3">
        <h1 class="text-justify fw-bold">My Dashboard</h1>
        <div class="mx-1">
            @include('components.alerts.success')
        </div>
        <div class="col-md-4 mt-3">
            <div class="shadow card bg">
                <div class="card-body">
                    <h1 class="display-1 text-center fw-bold">{{ $pending_tickets_count }}</h1>
                    <p class="text-muted text-center">My Pending Tickets</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-3">
            <div class="shadow card bg">
                <div class="card-body">
                    <h1 class="display-1 text-center fw-bold">{{ $solved_tickets_count }}</h1>
                    <p class="text-muted text-center">My Solved Tickets</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-3">
            <div class="shadow card bg">
                <div class="card-body">
                    <h1 class="display-1 text-center fw-bold">{{ $tickets_count }}</h1>
                    <p class="text-muted text-center">My Total Tickets</p>
                </div>
            </div>
        </div>
    </div>
</div>
