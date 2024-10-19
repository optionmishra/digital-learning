<!DOCTYPE html>
<html lang="en">

<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="Medieor - Admin Panel">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} | Admin Panel</title>
    <link rel="apple-touch-icon" sizes="57x57" href={{ asset('coreui/assets/favicon/apple-icon-57x57.png') }}>
    <link rel="apple-touch-icon" sizes="60x60" href={{ asset('coreui/assets/favicon/apple-icon-60x60.png') }}>
    <link rel="apple-touch-icon" sizes="72x72" href={{ asset('coreui/assets/favicon/apple-icon-72x72.png') }}>
    <link rel="apple-touch-icon" sizes="76x76" href={{ asset('coreui/assets/favicon/apple-icon-76x76.png') }}>
    <link rel="apple-touch-icon" sizes="114x114" href={{ asset('coreui/assets/favicon/apple-icon-114x114.png') }}>
    <link rel="apple-touch-icon" sizes="120x120" href={{ asset('coreui/assets/favicon/apple-icon-120x120.png') }}>
    <link rel="apple-touch-icon" sizes="144x144" href={{ asset('coreui/assets/favicon/apple-icon-144x144.png') }}>
    <link rel="apple-touch-icon" sizes="152x152" href={{ asset('coreui/assets/favicon/apple-icon-152x152.png') }}>
    <link rel="apple-touch-icon" sizes="180x180" href={{ asset('coreui/assets/favicon/apple-icon-180x180.png') }}>
    <link rel="icon" type="image/png" sizes="192x192"
        href={{ asset('coreui/assets/favicon/android-icon-192x192.png') }}>
    <link rel="icon" type="image/png" sizes="32x32" href={{ asset('coreui/assets/favicon/favicon-32x32.png') }}>
    <link rel="icon" type="image/png" sizes="96x96" href={{ asset('coreui/assets/favicon/favicon-96x96.png') }}>
    <link rel="icon" type="image/png" sizes="16x16" href={{ asset('coreui/assets/favicon/favicon-16x16.png') }}>
    <link rel="manifest" href={{ asset('coreui/assets/favicon/manifest.json') }}>
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="assets/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!-- Vendors styles-->
    <link rel="stylesheet" href={{ asset('coreui/vendors/simplebar/css/simplebar.css') }}>
    <link rel="stylesheet" href={{ asset('coreui/css/vendors/simplebar.css') }}>
    <!-- Main styles for this application-->
    <link href={{ asset('coreui/css/style.css') }} rel="stylesheet">
    <script src={{ asset('coreui/js/config.js') }}></script>
    <script src={{ asset('coreui/js/color-modes.js') }}></script>
    <link href={{ asset('coreui/vendors/@coreui/chartjs/css/coreui-chartjs.css') }} rel="stylesheet">

    {{-- <link href="{{ asset('DataTables/datatables.min.css') }}" rel="stylesheet">
    <script src="{{ asset('DataTables/datatables.min.js') }}"></script> --}}

    {{-- <link rel="stylesheet" href="{{ asset('toastr/toastr.min.css') }}">
    <script src="{{ asset('toastr/toastr.min.js') }}"></script> --}}

    @vite(['resources/css/admin.css'])
    @yield('top-scripts')
    @yield('styles')
</head>

<body>
    @include('partials.admin.sidebar')
    <div class="wrapper d-flex flex-column min-vh-100">
        @include('partials.admin.header')

        @yield('content')

        @include('partials.admin.footer')
    </div>

    <div id="loading" class="d-none">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- CoreUI and necessary plugins-->
    <script src={{ asset('coreui/vendors/@coreui/coreui/js/coreui.bundle.min.js') }}></script>
    <script src={{ asset('coreui/vendors/simplebar/js/simplebar.min.js') }}></script>
    <script>
        const header = document.querySelector('header.header');

        document.addEventListener('scroll', () => {
            if (header) {
                header.classList.toggle('shadow-sm', document.documentElement.scrollTop > 0);
            }
        });
    </script>

    @vite(['resources/js/admin.js'])
    @yield('bottom-scripts')
</body>

</html>
