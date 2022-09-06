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
                                <!--end auth-logo-box-->
                                <div class="text-center auth-logo-text">
                                    <img src="{{asset("$logo")}}" width="{{$porcentaje}}" alt="Logo Iglenube" class="auth-logo">
                                    <h4 class="mt-0 mb-3 mt-5">Iglenube</h4>
                                    <h5>Evento de la iglesia {{ $iglesia->nombre }}</h5>
                                    <p class="text-muted mb-0">Confirmar asistencia para la reunión de ministerio
                                        <b>{{ $asistencia }}</b>.</p>
                                </div>
                                <!--end auth-logo-text-->
                                <form class="form-horizontal auth-form my-4 needs-validation" novalidate id="formAsistencia" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="username">Digita tu número de documento para confirmar la asistencia</label>
                                        <div class="input-group mb-3">
                                            <span class="auth-form-icon">
                                                <i class="dripicons-user"></i>
                                            </span>
                                            <input type="number" name="documento" class="form-control" required>
                                            <input type="hidden" name="rd" value="{{ $rd }}">
                                            <input type="hidden" name="a" value="{{ $asistencia_id }}">
                                            <div class="invalid-feedback">
                                                ¡Este campo es obligatorio!
                                            </div>
                                        </div>
                                    </div>
                                    <!--end form-group-->
                                    <div class="form-group mb-0 row">
                                        <div class="col-12 mt-2">
                                            <button
                                                class="btn btn-gradient-primary btn-round btn-block waves-effect waves-light"
                                                type="submit" id="registrarAsistencia">Registrar asistencia<i
                                                    class="fas fa-sign-in-alt ml-1"></i>
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
    <link href="{{ asset('plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
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
    <script>
        $("#formAsistencia").submit(function(e) {
            e.preventDefault();
            $('#formAsistencia').addClass('was-validated');
            if ($('#formAsistencia')[0].checkValidity() === false) {
                event.stopPropagation();
            } else {
                $.ajax({
                    type: "post",
                    url: "/asistencias/ministerios",
                    data: new FormData($('#formAsistencia')[0]),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $("#registrarAsistencia").html(
                            "<i class='fa fa-spinner fa-pulse'></i><span class='sr-only'> Guardando...</span>Guardando ..."
                        );
                        $("#registrarAsistencia").attr("disabled", true);
                    },
                    dataType: "json",
                    success: function(data) {
                        $("#registrarAsistencia").html("Registrar asistencia");
                        $("#registrarAsistencia").removeAttr("disabled");
                        if (data.status == "success") {
                            $('#formAsistencia').removeClass('was-validated');
                            $("#formAsistencia")[0].reset();
                        }
                        Swal.fire({
                            icon: data.status,
                            title: data.title,
                            text: data.message,
                            confirmButtonText: 'OK',
                        });
                    }
                });
            }
        });
    </script>
</body>

</html>
