@extends('layouts.core')
@section('contenido')
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <h4 class="page-title">Crear vencimiento para forma de pago</h4>
                </div>
                <!--end page-title-box-->
            </div>
            <!--end col-->
        </div>
        <!-- end page title end breadcrumb -->
        <div class="card">
            <div class="card-body">
                <form class="needs-validation" enctype="multipart/form-data" novalidate id="nuevoVencimiento" method="post">
                    @csrf
                    <div class="form-row">
                        <div class="col-md-6 form-group">
                            <label for="validationCustom01">Porcentaje</label>
                            <input type="text" class="form-control" name="porcentaje" id="porcentaje" required>
                            <div class="invalid-feedback">
                                ¡El porcentaje es obligatorio!
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 form-group">
                            <label for="validationCustom01">Días</label>
                            <input type="text" class="form-control" name="dias" id="dias" required>
                            <div class="invalid-feedback">
                                ¡Los días son obligatorios!
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <a href="formas_pago/vencimiento"><button type="button"
                                class="btn btn-primary waves-effect waves-light" _msthash="2770885" _msttexthash="118105"
                                data-toggle="modal" data-target="#modalRegistrarVencimiento">Nuevo
                                vencimiento</button></a>
                    </div>

                    <div class="form-row">
                        <div class="col-md-12 text-center">
                            <button class="btn btn-primary" id="registrarVencimiento" type="submit">Crear vencimiento para
                                forma de
                                pago</button>
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- container -->
    @endsection
    @section('add-scripts')
        <script>
            $("#nuevoVencimiento").submit(function(e) {
                e.preventDefault();
                $('#nuevoVencimiento').addClass('was-validated');
                if ($('#nuevoVencimiento')[0].checkValidity() === false) {
                    event.stopPropagation();
                } else {
                    $.ajax({
                        type: "post",
                        url: "/formas_pago/vencimientos",
                        data: new FormData($('#nuevoVencimiento')[0]),
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend: function() {
                            $("#registrarVencimiento").html(
                                "<i class='fa fa-spinner fa-pulse'></i><span class='sr-only'> Registrando...</span>Registrando..."
                            );
                            $("#registrarVencimiento").attr("disabled", true);
                        },
                        dataType: "json",
                        success: function(data) {
                            $("#registrarVencimiento").html("Registrado");
                            $("#registrarVencimiento").removeAttr("disabled");
                            if (data.status == "success") {
                                $('#nuevoVencimiento').removeClass('was-validated');
                                location.href = "/formas_pago";
                            } else if (data.status == "error") {
                                $('#nuevoVencimiento').removeClass('was-validated');
                                Swal.fire({
                                    icon: data.status,
                                    title: data.title,
                                    text: data.message,
                                });
                            }
                        }
                    });
                }
            });
        </script>
    @endsection
