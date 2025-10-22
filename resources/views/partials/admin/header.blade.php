<header class="p-0 mb-4 header header-sticky">
    <div class="px-4 container-fluid border-bottom">
        <button class="header-toggler" type="button"
            onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()"
            style="margin-inline-start: -14px">
            <svg class="icon icon-lg">
                <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-menu') }}"></use>
            </svg>
        </button>
        {{-- <ul class="header-nav d-none d-lg-flex">
            <li class="nav-item"><a class="nav-link" href="#">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Users</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Settings</a></li>
        </ul> --}}
        {{-- <ul class="header-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <svg class="icon icon-lg">
                        <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-bell') }}"></use>
                    </svg></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <svg class="icon icon-lg">
                        <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-list-rich') }}"></use>
                    </svg></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <svg class="icon icon-lg">
                        <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-envelope-open') }}">
                        </use>
                    </svg></a>
            </li>
        </ul> --}}
        <ul class="header-nav">
            <li class="py-1 nav-item">
                <div class="mx-2 text-opacity-75 vr h-100 text-body"></div>
            </li>
            <li class="nav-item dropdown">
                <button class="px-2 py-2 btn btn-link nav-link d-flex align-items-center" type="button"
                    aria-expanded="false" data-coreui-toggle="dropdown">
                    <svg class="icon icon-lg theme-icon-active">
                        <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-contrast') }}"></use>
                    </svg>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" style="--cui-dropdown-min-width: 8rem">
                    <li>
                        <button class="dropdown-item d-flex align-items-center" type="button"
                            data-coreui-theme-value="light">
                            <svg class="icon icon-lg me-3">
                                <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-sun') }}">
                                </use>
                            </svg>Light
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item d-flex align-items-center" type="button"
                            data-coreui-theme-value="dark">
                            <svg class="icon icon-lg me-3">
                                <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-moon') }}">
                                </use>
                            </svg>Dark
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item d-flex align-items-center active" type="button"
                            data-coreui-theme-value="auto">
                            <svg class="icon icon-lg me-3">
                                <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-contrast') }}">
                                </use>
                            </svg>Auto
                        </button>
                    </li>
                </ul>
            </li>
            <li class="py-1 nav-item">
                <div class="mx-2 text-opacity-75 vr h-100 text-body"></div>
            </li>
            <li class="nav-item dropdown">
                <a class="py-0 nav-link pe-0" data-coreui-toggle="dropdown" href="#" role="button"
                    aria-haspopup="true" aria-expanded="false">
                    <div class="avatar avatar-md">
                        <img class="avatar-img" src="{{ asset('coreui/img/default_avatar.png') }}"
                            alt="{{ auth()->user()->name }}" />
                    </div>
                </a>
                <div class="pt-0 dropdown-menu dropdown-menu-end">
                    <div class="mb-2 dropdown-header bg-body-tertiary text-body-secondary fw-semibold rounded-top">
                        Account
                    </div>
                    {{-- <a class="dropdown-item" href="#">
                        <svg class="icon me-2">
                            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-bell"></use>
                        </svg>
                        Updates<span class="badge badge-sm bg-info ms-2">42</span></a><a class="dropdown-item"
                        href="#">
                        <svg class="icon me-2">
                            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-envelope-open"></use>
                        </svg>
                        Messages<span class="badge badge-sm bg-success ms-2">42</span></a><a class="dropdown-item"
                        href="#">
                        <svg class="icon me-2">
                            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-task"></use>
                        </svg>
                        Tasks<span class="badge badge-sm bg-danger ms-2">42</span></a><a class="dropdown-item"
                        href="#">
                        <svg class="icon me-2">
                            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-comment-square"></use>
                        </svg>
                        Comments<span class="badge badge-sm bg-warning ms-2">42</span></a>
                    <div class="my-2 dropdown-header bg-body-tertiary text-body-secondary fw-semibold">
                        <div class="fw-semibold">Settings</div>
                    </div>
                    <a class="dropdown-item" href="#">
                        <svg class="icon me-2">
                            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-user"></use>
                        </svg>
                        Profile</a><a class="dropdown-item" href="#">
                        <svg class="icon me-2">
                            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-settings"></use>
                        </svg>
                        Settings</a><a class="dropdown-item" href="#">
                        <svg class="icon me-2">
                            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-credit-card"></use>
                        </svg>
                        Payments<span class="badge badge-sm bg-secondary ms-2">42</span></a><a class="dropdown-item"
                        href="#">
                        <svg class="icon me-2">
                            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-file"></use>
                        </svg>
                        Projects<span class="badge badge-sm bg-primary ms-2">42</span></a> --}}
                    {{-- <div class="dropdown-divider"></div> --}}
                    {{-- <a class="dropdown-item" href="#">
                        <svg class="icon me-2">
                            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-lock-locked"></use>
                        </svg>
                        Lock Account</a> --}}
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <a class="dropdown-item" href="{{ route('admin.configurations.index') }}">
                            <svg class="icon me-2">
                                <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-settings') }}">
                                </use>
                            </svg>
                            Configurations
                        </a>

                        <button type="submit" class="dropdown-item" href="{{ route('logout') }}">
                            <svg class="icon me-2">
                                <use
                                    xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-account-logout') }}">
                                </use>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </li>
        </ul>
    </div>
    {{-- <div class="px-4 container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="my-0 breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active"><span>Dashboard</span></li>
            </ol>
        </nav>
    </div> --}}
</header>
