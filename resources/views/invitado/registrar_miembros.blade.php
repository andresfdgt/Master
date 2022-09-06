<!DOCTYPE html>
<html lang="en">
@include('layouts.head')

<body class="account-body accountbg">
    <!-- Log In page -->
    <div class="container">
        <div class="row vh-100 ">
            <div class="col-12 align-self-center">
                <div class="auth-page" style="max-width: 901px !important;">
                    <div class="card auth-card shadow-lg mt-5">
                        <div class="card-body">
                            <!--end auth-logo-box-->
                            <div class="text-center auth-logo-text">
                                <img src="{{asset("$logo")}}" width="{{$porcentaje}}" alt="Logo Iglenube" class="auth-logo">
                                <h4 class="mt-0 mb-2 mt-3">Iglenube</h4>
                                <p class="text-muted mb-0">Regístrate en la iglesia {{ $iglesia->nombre }} y haz
                                    parte
                                    de esta congregación.</p>
                            </div>
                            <form class="needs-validation" enctype="multipart/form-data" novalidate id="nuevoMiembro"
                                method="post">
                                @csrf
                                <input type="hidden" name="rd" value="{{ $rd }}">
                                <div class="form-row">
                                    <div class="col-md-6 mb-2">
                                        <label for="validationCustom01">Documento</label>
                                        <input type="text" class="form-control" name="documento">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="validationCustom01">Nombre</label>
                                        <input type="text" class="form-control" name="nombre" required>
                                        <div class="invalid-feedback">
                                            ¡El nombre es obligatorio!
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="validationCustom01">Dirección</label>
                                        <input type="text" class="form-control" name="direccion" required>
                                        <div class="invalid-feedback">
                                            ¡La dirección es obligatoria!
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="validationCustom01">Correo electrónico</label>
                                        <input type="email" class="form-control" name="email">
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label for="validationCustom01">Teléfono celular</label>
                                        <input type="text" class="form-control" name="telefono">
                                        <div class="invalid-feedback">
                                            ¡El nombre es obligatorio!
                                        </div>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        <label for="validationCustom01">Fecha de nacimiento</label>
                                        <input type="date" class="form-control" name="fecha_nacimiento">
                                        {{-- <div class="invalid-feedback">
                                         El nombre es obligatorio!
                                      </div> --}}
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label for="validationCustom01">Género</label>
                                        <select name="genero" class="form-control" required>
                                            <option value="">Seleccione</option>
                                            <option value="1">Masculino</option>
                                            <option value="0">Femenino</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            ¡El género es obligatorio!
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label for="validationCustom01">Estado civil</label>
                                        <select name="estado_civil" class="form-control" required>
                                            <option value="">Seleccione</option>
                                            <option value="1">Soltero</option>
                                            <option value="2">Casado</option>
                                            <option value="3">Unión libre</option>
                                            <option value="4">Viudo</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            ¡El estado civil es obligatorio!
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <h5>Datos de salud</h5>
                                        <div class="row">
                                            <div class="col-md-4 mb-2">
                                                <label for="validationCustom01">Tipo de sangre</label>
                                                <select name="tipo_sangre" class="form-control">
                                                    <option value="O+">O+</option>
                                                    <option value="O-">O-</option>
                                                    <option value="A+">A+</option>
                                                    <option value="A-">A-</option>
                                                    <option value="B+">B+</option>
                                                    <option value="B-">B-</option>
                                                    <option value="AB+">AB+</option>
                                                    <option value="AB-">AB-</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label for="validationCustom01">Capacidades diferentes o
                                                    especiales</label>
                                                <input type="text" class="form-control" name="discapacidad">
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label for="validationCustom01">Alergias o indicaciones medicas</label>
                                                <input type="text" class="form-control" name="alergias">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <h5>Ocupación</h5>
                                        <div class="row">
                                            <div class="col-md-4 mb-2">
                                                <label for="validationCustom01">Profesión u oficio</label>
                                                <input type="text" class="form-control" name="profesion">
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label for="validationCustom01">Lugar de trabajo (Centro de
                                                    estudio)</label>
                                                <input type="text" class="form-control" name="lugar_ocupacion">
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label for="validationCustom01">Puesto que ocupa (nivel
                                                    academico)</label>
                                                <input type="text" class="form-control" name="cargo">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="validationCustom01">Celula o grupo familiar al que
                                            perteneces</label>
                                        <select name="celula" class="form-control">
                                            <option value="">Seleccione</option>
                                            @foreach ($celulas as $celula)
                                                <option value='{{ $celula->id }}'>{{ $celula->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12 text-center">
                                        <button class="btn btn-primary btn-lg" id="registrarMiembro"
                                            type="submit">Registrarme como miembro</button>
                                    </div>
                                </div>
                            </form>
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
    <link href="{{ asset('plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
    <!-- App js -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        $("#nuevoMiembro").submit(function(e) {
            e.preventDefault();
            if ($('#nuevoMiembro')[0].checkValidity() === false) {
                event.stopPropagation();
            } else {
                $.ajax({
                    type: "post",
                    url: "/membresias/registro",
                    data: new FormData($('#nuevoMiembro')[0]),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $("#registrarMiembro").html(
                            "<i class='fa fa-spinner fa-pulse'></i><span class='sr-only'> Registrando...</span>Registrando..."
                        );
                        $("#registrarMiembro").attr("disabled", true);
                    },
                    dataType: "json",
                    success: function(data) {
                        $("#registrarMiembro").html("Registrarme como miembro");
                        $("#registrarMiembro").removeAttr("disabled");
                        if (data.status == "success") {
                            $('#nuevoMiembro').removeClass('was-validated');
                            $("#nuevoMiembro")[0].reset();
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
            $('#nuevoMiembro').addClass('was-validated');
        });
    </script>
    <script>
        // const matcher = window.matchMedia('(prefers-color-scheme: dark)');
        // matcher.addListener(onUpdate);

        // const lightSchemeIcon = document.querySelector('link#light-scheme-icon');
        // const darkSchemeIcon = document.querySelector('link#dark-scheme-icon');

        // function onUpdate() {
        //     console.log(matcher.matches)
        //     if (matcher.matches) {
        //         lightSchemeIcon.remove();
        //         document.head.append(darkSchemeIcon);
        //     } else {

        //         document.head.append(lightSchemeIcon);
        //         darkSchemeIcon.remove();
        //     }
        // }

        // onUpdate();
    </script>
</body>

</html>
