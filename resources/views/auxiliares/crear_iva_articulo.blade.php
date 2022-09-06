@extends('layouts.core')
@section('contenido')
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <h4 class="page-title">Crear IVA de artículo</h4>
                </div>
                <!--end page-title-box-->
            </div>
            <!--end col-->
        </div>
        <!-- end page title end breadcrumb -->
        <div class="card">
            <div class="card-body">
                <form class="needs-validation" enctype="multipart/form-data" novalidate id="nuevoIvaArticulo" method="post">
                    @csrf
                    <div class="form-row">
                        <div class="col-md-6 form-group">
                            <label for="validationCustom01">Descripcion</label>
                            <input type="text" class="form-control" name="descripcion" id="descripcion" required>
                            <div class="invalid-feedback">
                                ¡La descripción es obligatoria!
                            </div>
                        </div>

                        <div class="col-md-3 form-group">
                            <label for="validationCustom01">IVA %</label>
                            <input type="number" step="0.01" class="form-control" name="iva" id="iva" value="0">
                        </div>

                        <div class="col-md-3 form-group">
                            <label for="validationCustom01">Recargo de equivalencia %</label>
                            <input type="number" step="0.01" class="form-control" name="recargo" id="recargo" value="0">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="checkbox my-2">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="favorito" name="favorito" value="1">
                                <label class="custom-control-label" for="favorito">Favorito</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-12 text-center">
                            <button class="btn btn-primary" id="registrarIvaArticulo" type="submit">Crear IVA de
                                artículo</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- container -->
@endsection
@section('add-scripts')
    <script>
        $("#nuevoIvaArticulo").submit(function(e) {
            e.preventDefault();
            $('#nuevoIvaArticulo').addClass('was-validated');
            if ($('#nuevoIvaArticulo')[0].checkValidity() === false) {
                event.stopPropagation();
            } else {
                $.ajax({
                    type: "post",
                    url: "/iva/articulos/",
                    data: new FormData($('#nuevoIvaArticulo')[0]),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $("#registrarIvaArticulo").html(
                            "<i class='fa fa-spinner fa-pulse'></i><span class='sr-only'> Registrando...</span>Registrando..."
                        );
                        $("#registrarIvaArticulo").attr("disabled", true);
                    },
                    dataType: "json",
                    success: function(data) {
                        $("#registrarIvaArticulo").html("Registrado");
                        $("#registrarIvaArticulo").removeAttr("disabled");
                        if (data.status == "success") {
                            $('#nuevoIvaArticulo').removeClass('was-validated');
                            location.href = "/iva/articulos";
                        } else if (data.status == "error") {
                            $('#nuevoIvaArticulo').removeClass('was-validated');
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
