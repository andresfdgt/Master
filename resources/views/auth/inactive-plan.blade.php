<!DOCTYPE html>
<html lang="es">

<head>
    @include('../layouts.head')
    <style>
        .left-sidenav-menu li {
            margin-top: 0px !important;
        }

        body.enlarge-menu .page-wrapper {
            min-height: auto !important;
        }
    </style>
</head>

<body class="mm-active active enlarge-menu">
    @include('layouts.sidenav')

    @include('layouts.topbar')

    <div class="page-wrapper">
        <!-- Page Content-->
        <div class="page-content-tab text-center">
            <div class="container">
            <img style="width: 34%" class="mx-auto d-block pt-4" src="{{ asset('images/verify-email.svg') }}" alt="">
            <h3 class="">Tu plan está inactivo. Contácta con el administrador</h3>
       
            @include('layouts.footer')
        </div>
        <!-- end page content -->
    </div>

    @include('layouts.scripts')
    @yield('add-scripts')

</body>

</html>