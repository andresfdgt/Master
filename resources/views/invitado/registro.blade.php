<!DOCTYPE html>
<html lang="en">
@include('layouts.head')

<body class="account-body accountbg">
    <!-- Log In page -->
    <div class="container">
        <div class="row vh-100 ">
            <div class="col-12 align-self-center">
                <div class="auth-page mt-4" style="max-width: 60%">
                    <div class="card auth-card shadow-lg">
                        <div class="card-body">
                            <div class="px-3">
                                <!--end auth-logo-box-->
                                <div class="text-center auth-logo-text">
                                    <img src="{{ asset('images/logo.png') }}" width="70" alt="Logo Iglenube"
                                        class="auth-logo">
                                    <h4 class="mt-0 mb-1 mt-2">Regístrate</h4>
                                    <p class="text-muted mb-0">¡Obtén 7 días gratis ahora!</p>
                                </div>
                                <!--end auth-logo-text-->
                                <form class="form-horizontal auth-form my-4 needs-validation" novalidate
                                    id="formRegistro" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="nombre_iglesia">Nombre</label>
                                            <div class="input-group">
                                                <span class="auth-form-icon">
                                                    <i class="dripicons-user"></i>
                                                </span>
                                                <input type="text" class="form-control" name="nombre" id="nombre" required>
                                                <div class="invalid-feedback">
                                                    ¡El nombre es obligatorio!
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="nombre_iglesia">Razon social</label>
                                            <div class="input-group">
                                                <span class="auth-form-icon">
                                                    <i class="dripicons-briefcase"></i>
                                                </span>
                                                <input type="text" class="form-control" name="razon_social"
                                                    id="nombre" required>
                                                <div class="invalid-feedback">
                                                    ¡El nombre es obligatorio!
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="cfi_dni">cif/dni</label>
                                            <div class="input-group">
                                                <span class="auth-form-icon">
                                                    <i class="dripicons-pencil"></i>
                                                </span>
                                                <input type="text" class="form-control" name="cif_dni" id="cfi_dni" required>
                                                <div class="invalid-feedback">
                                                    ¡El cif o dni es obligatorio!
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="pais">Pais</label>
                                            <div class="input-group">
                                                <span class="auth-form-icon">
                                                    <i class="dripicons-flag"></i>
                                                </span>
                                                <input type="text" class="form-control" name="pais" id="pais" required>
                                                <div class="invalid-feedback">
                                                    ¡El pais es obligatorio!
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="codigo_postal">Codigo postal</label>
                                            <div class="input-group">
                                                <span class="auth-form-icon">
                                                    <i class="dripicons-user-id"></i>
                                                </span>
                                                <input type="text" class="form-control" name="codigo_postal"
                                                    id="codigo_postal" required>
                                                <div class="invalid-feedback">
                                                    ¡El pais es obligatorio!
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="localidad">Localidad</label>
                                            <div class="input-group">
                                                <span class="auth-form-icon">
                                                    <i class="dripicons-map"></i>
                                                </span>
                                                <input type="text" class="form-control" name="localidad"
                                                    id="localidad"  required>
                                                <div class="invalid-feedback">
                                                    ¡La localidad es obligatoria!
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="localidad">Provincia</label>
                                            <div class="input-group">
                                                <span class="auth-form-icon">
                                                    <i class="dripicons-home"></i>
                                                </span>
                                                <input type="text" class="form-control" name="provincia"
                                                    id="provincia" required>
                                                <div class="invalid-feedback">
                                                    ¡La localidad es obligatoria!
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                          <label for="direccion">Dirección</label>
                                          <div class="input-group">
                                              <span class="auth-form-icon">
                                                  <i class="dripicons-direction
                                                  "></i>
                                              </span>
                                              <input type="text" class="form-control" name="direccion"
                                                  id="direccion" required>
                                              <div class="invalid-feedback">
                                                  ¡La dirección es obligatoria!
                                              </div>
                                          </div>
                                      </div>
                                        <div class="form-group col-md-6">
                                            <label for="telefono">Telefono 1</label>
                                            <div class="input-group">
                                                <span class="auth-form-icon">
                                                    <i class="dripicons-phone"></i>
                                                </span>
                                                <input type="number" class="form-control" name="telefono"
                                                    id="telefono" required>
                                                <div class="invalid-feedback">
                                                    ¡La telefono es obligatoria!
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="telefono_2">Telefono 2</label>
                                            <div class="input-group">
                                                <span class="auth-form-icon">
                                                    <i class="dripicons-phone"></i>
                                                </span>
                                                <input type="number" class="form-control" name="telefono_2"
                                                    id="telefono_2">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="email">Correo electrónico</label>
                                            <div class="input-group">
                                                <span class="auth-form-icon">
                                                    <i class="dripicons-mail"></i>
                                                </span>
                                                <input type="email" class="form-control" name="email" id="email" required>
                                                <div class="invalid-feedback">
                                                    ¡El email es obligatorio!
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="password">Contraseña</label>
                                            <div class="input-group">
                                                <span class="auth-form-icon">
                                                    <i class="dripicons-lock"></i>
                                                </span>
                                                <input type="password" class="form-control" name="password"
                                                    id="password" required>
                                                <div class="invalid-feedback">
                                                    ¡La contraseña es obligatoria!
                                                </div>
                                            </div>
                                        </div>
                                        <!--end form-group-->
                                        <div class="form-group col-md-6">
                                            <label for="conf_password">Confirmar Contraseña</label>
                                            <div class="input-group">
                                                <span class="auth-form-icon">
                                                    <i class="dripicons-lock-open"></i>
                                                </span>
                                                <input type="password" class="form-control"
                                                    name="password_confirmation" id="password_confirmation" required>
                                                <div class="invalid-feedback">
                                                    ¡La confirmación es obligatoria!
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mt-4 text-center">
                                        <div class="col-sm-12">
                                            <div class="custom-control custom-switch switch-success">
                                                <input type="checkbox" class="custom-control-input"
                                                    id="customSwitchSuccess">
                                                <label class="custom-control-label text-muted"
                                                    for="customSwitchSuccess">Al registrarse, acepta los <a
                                                        target="_blank" href="/terminos" class="text-primary">Términos
                                                        de uso</a></label>
                                            </div>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end form-group-->
                                    <div class="form-group mb-0 row">
                                        <div class="col-12 mt-2">
                                            <button id="registrar"
                                                class="btn btn-gradient-primary btn-round btn-block waves-effect waves-light"
                                                type="submit">Registrar <i class="fas fa-sign-in-alt ml-1"></i></button>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end form-group-->
                                </form>
                                <!--end form-->
                            </div>
                            <!--end /div-->
                            <div class="text-center text-muted">
                                <p class="mb-0">¿Ya tienes una cuenta?<a href="/auth"
                                        class="text-primary ml-1">Inicia
                                        sesión</a></p>
                            </div>
                        </div>
                        <!--end card-body-->
                    </div>
                    <!--end card-->
                </div>
                <!--end auth-card-->
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
    <script>
        $("#formRegistro").submit(function(e) {
            e.preventDefault();
            if ($('#formRegistro')[0].checkValidity() === false) {
                event.stopPropagation();
            } else {
                $.ajax({
                    type: "post",
                    url: "/registro",
                    data: new FormData($('#formRegistro')[0]),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $("#registrar").html(
                            "<i class='fa fa-spinner fa-pulse'></i><span class='sr-only'> Registrando...</span>Registrando..."
                        );
                        $("#registrar").attr("disabled", true);
                    },
                    dataType: "json",
                    success: function(data) {
                        $("#registrar").html("Registrar");
                        $("#registrar").removeAttr("disabled");
                        if (data.status == "success") {
                            $('#formRegistro').removeClass('was-validated');
                            $("#formRegistro")[0].reset();
                        }
                        Swal.fire({
                            icon: data.status,
                            title: data.title,
                            text: data.message,
                            confirmButtonText: 'OK',
                        }).then((result) => {
                            if (result.value) {
                                if (data.status == "success") {
                                    location.href = "/auth"
                                }
                            }
                        });
                    }
                });
            }
            $('#formRegistro').addClass('was-validated');
        });
    </script>
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
