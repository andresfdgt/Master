@extends('layouts.core')
@section('contenido')
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <h4 class="page-title">Editar IVA de artículo</h4>
                </div>
                <!--end page-title-box-->
            </div>
            <!--end col-->
        </div>
        <!-- end page title end breadcrumb -->
        <div class="card">
            <div class="card-body">
                <form class="needs-validation" enctype="multipart/form-data" novalidate id="editarIvaArticulo" method="post">
                    @csrf
                    @method('put')

                    <div class="form-row">
                        <div class="col-md-3 form-group">
                            <label for="validationCustom01">Descripción</label>
                            <input type="hidden" name="id" value="{{ $ivaArticulo->id }}">
                            <input type="text" class="form-control" name="descripcion"
                                value="{{ $ivaArticulo->descripcion }}" required>
                            <div class="invalid-feedback">
                                ¡La descripción es obligatoria!
                            </div>
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="validationCustom01">IVA %</label>
                            <input type="number" step="0.01" class="form-control" name="iva" id="iva"
                                value="{{ $ivaArticulo->iva }}">
                        </div>

                        <div class="col-md-3 form-group">
                            <label for="validationCustom01">Recargo de equivalencia %</label>
                            <input type="number" step="0.01" class="form-control" name="recargo" id="recargo"
                                value="{{ $ivaArticulo->recargo }}">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="checkbox my-2">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="favorito" name="favorito"
                                    value="1" {{ $ivaArticulo->favorito == 1 ? 'checked' : '' }}>
                                <label class="custom-control-label" for="favorito">Favorito</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-12 text-center">
                            <button class="btn btn-primary btn-lg" id="actualizarIvaArticulo" type="submit">Editar
                                IVA de artículo</button>
                        </div>
                    </div>
                </form>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
        <!--end col-->
        <!--end row-->
    </div><!-- container -->
@endsection
@section('add-scripts')
    <script>
        $("#editarIvaArticulo").submit(function(e) {
            e.preventDefault();
            $('#editarIvaArticulo').addClass('was-validated');
            if ($('#editarIvaArticulo')[0].checkValidity() === false) {
                event.stopPropagation();
            } else {
                $.ajax({
                    type: "post",
                    url: "/iva/articulos/",
                    data: new FormData($('#editarIvaArticulo')[0]),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $("#actualizarIvaArticulo").html(
                            "<i class='fa fa-spinner fa-pulse'></i><span class='sr-only'> Actualizando...</span>Actualizando..."
                        );
                        $("#actualizarIvaArticulo").attr("disabled", true);
                    },
                    dataType: "json",
                    success: function(data) {
                        $("#actualizarIvaArticulo").html("Actualizado");
                        $("#actualizarIvaArticulo").removeAttr("disabled");
                        if (data.status == "success") {
                            $('#editarIvaArticulo').removeClass('was-validated');
                            location.href = "/iva/articulos"
                        } else if (data.status == "error") {
                            $('#editarIvaArticulo').removeClass('was-validated');
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
