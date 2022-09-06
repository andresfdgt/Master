@extends('layouts.core')
@section('add-head')
@endsection
@section('contenido')
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <h4 class="page-title">Perfíl</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="tab-pane">
                    <div class="row">
                        <div class="col-lg-12 col-xl-9 mx-auto">
                            <div class="card">
                                <div class="card-body">
                                    <div class="">
                                        <form class="form-horizontal form-material mb-0 needs-validation" novalidate
                                            id="perfil" method="post">
                                            @csrf
                                            @method("put")
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <input type="text" name="nombre" placeholder="Nombre completo"
                                                        class="form-control" value="{{ ucwords(auth()->user()->nombre) }}">
                                                        <div class="invalid-feedback">
                                                         ¡El nombre es obligatorio!
                                                       </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="email" placeholder="Email" class="form-control" readonly
                                                        value="{{ auth()->user()->email }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <input type="password" name="password" placeholder="Contraseña"
                                                        class="form-control" required autocomplete="off">
                                                        <div class="invalid-feedback">
                                                         ¡La contraseña es obligatoria!
                                                       </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="password" name="password_confirmation"
                                                        placeholder="Repetir contraseña" class="form-control" required>
                                                      <div class="invalid-feedback">
                                                         ¡La confirmación de la contraseña es obligatoria!
                                                       </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" id="actualizarPerfil"
                                                    class="btn btn-gradient-primary btn-sm px-4 mt-3 float-right mb-0">Actualizar
                                                    perfíl</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('add-scripts')
    <script>
        $("#perfil").submit(function(e) {
            e.preventDefault();
            $('#perfil').addClass('was-validated');
            if ($('#perfil')[0].checkValidity() === false) {
                event.stopPropagation();
            } else {
                $.ajax({
                    type: "post",
                    url: "/perfil",
                    data: new FormData($('#perfil')[0]),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $("#actualizarperfil").html(
                            "<i class='fa fa-spinner fa-pulse'></i><span class='sr-only'> Actualizando...</span>Actualizando..."
                        );
                        $("#actualizarperfil").attr("disabled", true);
                    },
                    dataType: "json",
                    success: function(data) {
                        $("#actualizarPerfil").html("Actualizar");
                        $("#actualizarPerfil").removeAttr("disabled");
                        Swal.fire({
                            icon: data.status,
                            title: data.title,
                            text: data.message,
                            confirmButtonText: 'OK',
                        }).then((result) => {
                            if (result.value) {
                                if (data.status == "success") {
                                    location.reload();
                                }
                            }
                        });
                    }
                });
            }
        });

    </script>
@endsection
