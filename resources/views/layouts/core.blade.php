<!DOCTYPE html>
<html lang="es">

<head>
    @include('layouts.head')
    @yield('add-head')
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
        <div class="page-content-tab">

          @yield('contenido')
          @include('layouts.footer')
        </div>
        <!-- end page content -->
    </div>

    @include('layouts.scripts')
    @include('layouts.base')
    @yield('add-scripts')

</body>

</html>
