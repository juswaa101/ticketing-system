<style>
    a {
        color: white !important;
    }
</style>
<div class="container-fluid">
    <div class="row flex-nowrap">
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
            <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                <a href="{{ route('landing-page') }}"
                    class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    <span class="fs-5 d-none d-sm-inline">Ticketing System</span>
                </a>
                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start"
                    id="menu">
                    <li>
                        <a href="@can('admin') /admin-dashboard @else /dashboard @endcan"
                            class="nav-link px-0 align-middle">
                            <i class="fs-4 bi-speedometer2"></i> <span class="ms-1 d-none d-sm-inline">Dashboard</span>
                        </a>
                    </li>
                    @if (auth()->user()->email_verified_at != null)
                        @can('admin')
                            <li>
                                <a href="{{ route('users.index') }}" class="nav-link px-0 align-middle">
                                    <i class="fs-4 bi-people"></i> <span class="ms-1 d-none d-sm-inline">Users</span></a>
                            </li>
                            <li>
                                <a href="{{ route('roles.index') }}" class="nav-link px-0 align-middle ">
                                    <i class="fs-4 bi-shield-lock-fill"></i> <span
                                        class="ms-1 d-none d-sm-inline">Roles</span></a>
                            </li>
                            <li>
                                <a href="{{ route('admin-tickets.index') }}" class="nav-link px-0 align-middle">
                                    <i class="fs-4 bi-ticket-fill"></i> <span class="ms-1 d-none d-sm-inline">Tickets</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('logs.index') }}" class="nav-link px-0 align-middle">
                                    <i class="fs-4 bi-newspaper"></i> <span class="ms-1 d-none d-sm-inline">Ticket
                                        Logs</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('categories.index') }}" class="nav-link px-0 align-middle">
                                    <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Categories</span>
                                </a>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('user-tickets.index') }}" class="nav-link px-0 align-middle">
                                    <i class="fs-4 bi-ticket-fill"></i> <span class="ms-1 d-none d-sm-inline">Tickets</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('logs.user.index') }}" class="nav-link px-0 align-middle">
                                    <i class="fs-4 bi-newspaper"></i> <span class="ms-1 d-none d-sm-inline">Ticket
                                        Logs</span>
                                </a>
                            </li>
                        @endcan
                    @endif
                </ul>
                <hr>
                <div class="dropdown pb-4">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                        id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=0D8ABC&color=fff"
                            alt="hugenerd" width="30" height="30" class="rounded-circle">
                        <span class="d-none d-sm-inline mx-1">{{ auth()->user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                        <li><a class="dropdown-item" href="{{ route('settings.view') }}">Settings</a></li>
                        <li><a class="dropdown-item" href="{{ route('profile.view') }}">Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}">Sign out</a></li>
                    </ul>
                </div>
            </div>
        </div>
        @if (Route::is('profile.view'))
            @include('auth.profile')
        @elseif(Route::is('settings.view'))
            @include('auth.settings')
        @endif

        @if (auth()->user()->email_verified_at != null)
            @can('admin')
                @if (Route::is('admin.dashboard'))
                    @include('auth.admin.pages.dashboard-content')
                @elseif(Route::is('admin-tickets.index'))
                    @include('auth.admin.pages.ticket-content')
                @elseif (Route::is('categories.index'))
                    @include('auth.admin.pages.categories-content')
                @elseif (Route::is('users.index'))
                    @include('auth.admin.pages.user-content')
                @elseif (Route::is('roles.index'))
                    @include('auth.admin.pages.roles-content')
                @elseif (Route::is('logs.index'))
                    @include('auth.admin.pages.ticket-logs-content')
                @endif
            @else
                @if (Route::is('user.dashboard'))
                    @include('auth.user.pages.dashboard-content')
                @elseif(Route::is('user-tickets.index'))
                    @include('auth.user.pages.ticket-content')
                @elseif (Route::is('logs.user.index'))
                    @include('auth.user.pages.ticket-logs-content')
                @endif
            @endcan
        @else
            @if (Route::is('verify'))
                @include('auth.verify_email')
            @endif

            {{-- @dd(Route::current()->getName()) --}}
        @endif
    </div>
</div>
