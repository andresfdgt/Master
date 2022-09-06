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
            <h3 class="">Para continuar debes verificar tu email</h3>

            @if (session()->get('message'))
                <div class="alert icon-custom-alert alert-outline-success alert-success-shadow" role="alert">
                    <i class="mdi mdi-check-all alert-icon"></i>
                    <div class="alert-text">
                        Correo de verificación enviado correctamente
                    </div>                                            
                </div>
            @else
            <form action="{{route('verification.send')}}" method="post">
                @csrf
                <button class="btn btn-primary">Re-enviar email de verificación</button>
            </form>
            @endif
 
       
            @include('layouts.footer')
        </div>
        <!-- end page content -->
    </div>

    @include('layouts.scripts')
    @yield('add-scripts')

</body>

</html>