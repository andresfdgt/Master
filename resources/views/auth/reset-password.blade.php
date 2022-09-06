<!DOCTYPE html>
<html lang="en">


@include('layouts.head')

<body class="account-body accountbg">
    <!-- Log In page -->
    <div class="container">
        <div class="row vh-100 ">
            <div class="col-12 align-self-center">
                <div class="auth-page">
                    <div class="card auth-card shadow-lg">
                        <div class="card-body">
                            <div class="px-3">
                                <div class="text-center auth-logo-text">
                                    <img src="{{ asset('images/logo.png') }}" width="70" alt="Logo Iglenube"
                                        class="auth-logo">
                                    <p class="text-muted mb-0">Recuperación de contraseña</p>
                                </div>
                                <!--end auth-logo-text-->
                                <form class="form-horizontal auth-form my-4" action="{{ route('password.update') }}"
                                    method="POST">
                                    @csrf
                                    <input type="hidden" name="token" value="{{$token}}">
                                    <div class="form-group">
                                        <label for="username">Correo electrónico</label>
                                        <div class="input-group mb-3">
                                            <span class="auth-form-icon">
                                                <i class="dripicons-user"></i>
                                            </span>
                                            <input type="email" name="email" class="form-control" value="{{old('email')}}" id="username"
                                                placeholder="Correo electrónico">
                                        </div>
                                    </div>
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <div class="form-group">
                                        <label for="username">Contraseña</label>
                                        <div class="input-group mb-3">
                                            <span class="auth-form-icon">
                                                <i class="dripicons-user"></i>
                                            </span>
                                            <input type="password" name="password" class="form-control" value="{{old('password')}}" id="username"
                                                placeholder="Correo electrónico">
                                        </div>
                                    </div>
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <!--end form-group-->

                                    <div class="form-group">
                                        <label for="username">Contraseña</label>
                                        <div class="input-group mb-3">
                                            <span class="auth-form-icon">
                                                <i class="dripicons-user"></i>
                                            </span>
                                            <input type="password" name="password_confirmation" class="form-control" value="{{old('password_confirmation')}}" id="username"
                                                placeholder="Correo electrónico">
                                        </div>
                                    </div>
                                    @error('password_confirmation')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <!--end form-group-->
                                    
                                    <div class="form-group mb-0 row">
                                        <div class="col-12 mt-2">
                                            <button class="btn btn-gradient-primary btn-round btn-block waves-effect waves-light"
                                                type="submit">Recuperar<i class="fas fa-sign-in-alt ml-1"></i>
                                            </button>
                                        </div>
                                        <!--end col-->
                                    </div>
                      
                                    <!--end form-group-->
                                </form>
                                <!--end form-->
                            </div>
                            <!--end /div-->
                        </div>
                        <!--end card-body-->
                    </div>
                    <!--end card-->
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
</body>

</html>
