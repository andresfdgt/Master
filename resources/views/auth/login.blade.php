<!DOCTYPE html>
<html lang="en">

@include('layouts.head')

<body class="account-body accountbg" style="backdrop-filter: blur(7px);">
    <!-- Log In page -->
    <div class="container">
        <div class="row vh-100 ">
            <div class="col-12 align-self-center">
                <div class="auth-page">
                    <div class="card auth-card shadow-lg">
                        <div class="card-body">
                            <div class="px-3 mt-3">
                                <!--end auth-logo-box-->
                                <div class="text-center auth-logo-text">
                                    <img src="{{ asset('images/logo.png') }}" width="70" alt="Logo Iglenube"
                                        class="auth-logo">
                                    <h3 class="mb-0 mt-2 fs-4">Inicia sesión</h3>
                                </div>
                                <!--end auth-logo-text-->
                                <form class="form-horizontal auth-form my-3" action="{{ route('auth') }}"
                                    method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="username">Correo electrónico</label>
                                        <div class="input-group mb-3">
                                            <span class="auth-form-icon">
                                                <i class="dripicons-user"></i>
                                            </span>
                                            <input type="email" name="correo"
                                                class="form-control @error('correo') is-invalid @enderror"
                                                value="{{ old('correo') }}" id="username"
                                                placeholder="Correo electrónico">
                                            @error('correo')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!--end form-group-->
                                    <div class="form-group">
                                        <label for="userpassword">Contraseña</label>
                                        <div class="input-group mb-3">
                                            <span class="auth-form-icon">
                                                <i class="dripicons-lock"></i>
                                            </span>
                                            <input type="password" name="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                placeholder="Contraseña">
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!--end form-group-->
                                    <div class="form-group row mt-4">
                                        <div class="col-sm-5">
                                            <div class="custom-control custom-switch switch-success">
                                                <input type="checkbox" name="recordar" class="custom-control-input"
                                                    id="customSwitchSuccess" style="cursor: pointer">
                                                <label class="custom-control-label text-muted" for="customSwitchSuccess"
                                                    style="cursor: pointer">Recordar</label>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-sm-7 text-right">
                                            <a href="{{ route('password.request') }}" class="text-muted font-13">
                                                <i class="dripicons-lock"></i> ¿Olvidaste tu contraseña?
                                            </a>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end form-group-->
                                    <div class="form-group mb-0 row">
                                        <div class="col-12 mt-2">
                                            <button
                                                class="btn btn-gradient-primary btn-round btn-block waves-effect waves-light"
                                                type="submit">Iniciar sesión<i class="fas fa-sign-in-alt ml-1"></i>
                                            </button>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end form-group-->
                                </form>
                                <!--end form-->
                            </div>
                            <!--end /div-->
                            {{-- <div class="text-center text-muted">
                                <p class="mb-0">¿No tienes una cuenta?
                                    <a href="/registro" class="text-primary ml-2">¡Regístrate gratis!</a>
                                </p>
                            </div> --}}
                        </div>
                        <!--end card-body-->
                    </div>
                    <!--end card-->
                    {{-- <div class="account-social text-center mt-4">
                        <h6 class="my-4">Or Login With</h6>
                        <ul class="list-inline mb-4">
                            <li class="list-inline-item">
                                <a href="" class="">
                                    <i class="fab fa-facebook-f facebook"></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="" class="">
                                    <i class="fab fa-twitter twitter"></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="" class="">
                                    <i class="fab fa-google google"></i>
                                </a>
                            </li>
                        </ul>
                    </div> --}}
                    <!--end account-social-->
                </div>
                <!--end auth-page-->
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>
    <!--end container-->
    <!-- End Log In page -->
    <!-- jQuery  -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/metismenu.min.js') }}"></script>
    <script src="{{ asset('js/waves.js') }}"></script>
    <script src="{{ asset('js/feather.min.js') }}"></script>
    <script src="{{ asset('js/jquery.slimscroll.min.js') }}"></script>
    <!-- App js -->
    <script src="{{ asset('js/app.js') }}"></script>
    {{-- <script>
        const matcher = window.matchMedia('(prefers-color-scheme: dark)');
        matcher.addListener(onUpdate);

        const lightSchemeIcon = document.querySelector('link#light-scheme-icon');
        const darkSchemeIcon = document.querySelector('link#dark-scheme-icon');

        function onUpdate() {
            if (matcher.matches) {
                document.head.append(lightSchemeIcon);
                darkSchemeIcon.remove();
            } else {
                lightSchemeIcon.remove();
                document.head.append(darkSchemeIcon);
            }
        }

        onUpdate();
    </script> --}}
</body>

</html>
