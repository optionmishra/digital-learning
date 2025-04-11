@php
    $user = auth()->user();
@endphp
<div class="sidebar sidebar-dark sidebar-fixed border-end" id="sidebar">
    <div class="sidebar-header border-bottom">
        <div class="sidebar-brand">
            <h5>{{ config('app.name', 'Laravel') }}</h5>
            {{-- <p class="text-center">Admin Panel</p> --}}
            {{-- <svg class="sidebar-brand-full" width="88" height="32" alt="CoreUI Logo">
                <use xlink:href="{{ asset('coreui/assets/brand/coreui.svg#full') }}"></use>
            </svg>
            <svg class="sidebar-brand-narrow" width="32" height="32" alt="CoreUI Logo">
                <use xlink:href="{{ asset('coreui/assets/brand/coreui.svg#signet') }}"></use>
            </svg> --}}
        </div>
        <button class="btn-close d-lg-none" type="button" data-coreui-dismiss="offcanvas" data-coreui-theme="dark"
            aria-label="Close"
            onclick="coreui.Sidebar.getInstance(document.querySelector(&quot;#sidebar&quot;)).toggle()"></button>
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-speedometer') }}"></use>
                </svg> Dashboard</a></li>
        {{-- </svg> Dashboard<span class="badge badge-sm bg-info ms-auto">NEW</span></a></li> --}}

        <li class="nav-item"><a class="nav-link" href="{{ route('admin.schools.index') }}">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-list-rich') }}"></use>
                </svg> Schools</a></li>

        <li class="nav-item"><a class="nav-link" href="{{ route('admin.boards.index') }}">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-list-rich') }}"></use>
                </svg> Boards</a></li>

        <li class="nav-item"><a class="nav-link" href="{{ route('admin.series.index') }}">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-list-rich') }}"></use>
                </svg> Series</a></li>

        <li class="nav-item"><a class="nav-link" href="{{ route('admin.standards.index') }}">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-list-rich') }}"></use>
                </svg> Standards</a></li>

        <li class="nav-item"><a class="nav-link" href="{{ route('admin.subjects.index') }}">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-list-rich') }}"></use>
                </svg> Subjects</a></li>

        <li class="nav-item"><a class="nav-link" href="{{ route('admin.authors.index') }}">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-list-rich') }}"></use>
                </svg> Authors</a></li>

        <li class="nav-item"><a class="nav-link" href="{{ route('admin.books.index') }}">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-list-rich') }}"></use>
                </svg> Books</a></li>

        <li class="nav-item"><a class="nav-link" href="{{ route('admin.articles.index') }}">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-list-rich') }}"></use>
                </svg> Articles</a></li>

        <li class="nav-item"><a class="nav-link" href="{{ route('admin.content_types.index') }}">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-list-rich') }}"></use>
                </svg> Content Types</a></li>

        <li class="nav-group"><a class="nav-link nav-group-toggle" href="#">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-list-rich') }}"></use>
                </svg> Contents</a>
            <ul class="nav-group-items compact">
                @foreach (App\Models\ContentType::all() as $contentType)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.contents.index', "type=$contentType->id") }}">
                            <span class="nav-icon"><span class="nav-icon-bullet"></span></span>
                            {{ $contentType->name }}s</a>
                    </li>
                @endforeach
            </ul>
        </li>
        <li class="nav-item"><a class="nav-link" href="{{ route('admin.topics.index') }}">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-list-rich') }}"></use>
                </svg> Topics</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('admin.assessments.index') }}">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-list-rich') }}"></use>
                </svg> Assessments</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('admin.questions.index') }}">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-list-rich') }}"></use>
                </svg> Questions</a></li>

        <li class="nav-group"><a class="nav-link nav-group-toggle" href="#">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-list-rich') }}"></use>
                </svg> Users</a>
            <ul class="nav-group-items compact">
                @foreach (App\Models\Role::all() as $role)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.users.index', "role=$role->id") }}">
                            <span class="nav-icon"><span class="nav-icon-bullet"></span></span>
                            {{ ucfirst($role->name) }}s</a>
                    </li>
                @endforeach
            </ul>
        </li>

        {{-- @if (!$user->hasRestriction('can_manage_infopages')) --}}
        {{-- <li class="nav-group"><a class="nav-link nav-group-toggle" href="#">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-info') }}"></use>
                </svg> Web Pages</a>
            <ul class="nav-group-items compact">
                <li class="nav-item"><a class="nav-link" href="#"><span class="nav-icon"><span
                                class="nav-icon-bullet"></span></span> Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#"><span class="nav-icon"><span
                                class="nav-icon-bullet"></span></span> About Us</a></li>
                <li class="nav-item"><a class="nav-link" href="#"><span class="nav-icon"><span
                                class="nav-icon-bullet"></span></span> Contact Us</a></li>
            </ul>
        </li> --}}
        {{-- @endif --}}
    </ul>
    <div class="sidebar-footer border-top d-none d-md-flex">
        <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
    </div>
</div>
