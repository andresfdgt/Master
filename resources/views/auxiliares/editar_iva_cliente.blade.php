@extends('layouts.core')
@section('contenido')
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <h4 class="page-title">Editar IVA de cliente</h4>
                </div>
                <!--end page-title-box-->
            </div>
            <!--end col-->
        </div>
        <!-- end page title end breadcrumb -->
        <div class="card">
            <div class="card-body">
                <form class="needs-validation" enctype="multipart/form-data" novalidate id="editarIvaCliente" method="post">
                    @csrf
                    @method('put')

                    <div class="form-row">
                        <div class="col-md-3 form-group">
                            <label for="validationCustom01">Descripción</label>
                            <input type="hidden" name="id" value="{{ $ivaCliente->id }}">
                            <input type="text" class="form-control" name="descripcion"
                                value="{{ $ivaCliente->descripcion }}" required>
                            <div class="invalid-feedback">
                                ¡La descripción es obligatoria!
                            </div>
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="validationCustom01">IVA %</label>
                            <input type="number" step="0.01" class="form-control" name="iva" id="iva"
                                value="{{ $ivaCliente->iva }}">
                        </div>

                        <div class="col-md-3 form-group">
                            <label for="validationCustom01">Recargo de equivalencia %</label>
                            <input type="number" step="0.01" class="form-control" name="recargo" id="recargo"
                                value="{{ $ivaCliente->recargo }}">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="checkbox my-2">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="favorito" name="favorito"
                                    value="1" {{ $ivaCliente->favorito == 1 ? 'checked' : '' }}>
                                <label class="custom-control-label" for="favorito">Favorito</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="px-4 pt-2">
                                    <h5 class="mb-0">Observaciones</h5>
                                </div>
                                <div class="card-body">
                                    <input type="hidden" name="observaciones" id="observaciones_hidden">
                                    <textarea id="observaciones" cols="30" rows="10">{{ $ivaCliente->observaciones }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-12 text-center">
                            <button class="btn btn-primary btn-lg" id="actualizarIvaArtículo" type="submit">Editar
                                IVA de cliente</button>
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
    <script src="{{ asset('plugins/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('plugins/tinymce/langs/es.js') }}"></script>
    <script>
        $(document).ready(function() {
            var configEditor = {
                theme: "modern",
                height: 150,
                plugins: [
                    "advlist autolink link preview hr pagebreak",
                    "save directionality paste textcolor "
                ],
                toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link preview | forecolor backcolor emoticons ",
                style_formats: [{
                        title: 'Bold text',
                        inline: 'b'
                    },
                    {
                        title: 'Red text',
                        inline: 'span',
                        styles: {
                            color: '#ff0000'
                        }
                    },
                    {
                        title: 'Red header',
                        block: 'h1',
                        styles: {
                            color: '#ff0000'
                        }
                    },
                    {
                        title: 'Example 1',
                        inline: 'span',
                        classes: 'example1'
                    },
                    {
                        title: 'Example 2',
                        inline: 'span',
                        classes: 'example2'
                    },
                ]
            };
            if ($("#observaciones").length > 0) {
                tinymce.init({
                    ...configEditor,
                    language: "es",
                    selector: "textarea#observaciones",
                });
            }
        });
        $("#editarIvaCliente").submit(function(e) {
            e.preventDefault();
            $('#editarIvaCliente').addClass('was-validated');
            if ($('#editarIvaCliente')[0].checkValidity() === false) {
                event.stopPropagation();
            } else {
                $("#observaciones_hidden").val(tinymce.get('observaciones').getContent());
                $.ajax({
                    type: "post",
                    url: "/iva/clientes/",
                    data: new FormData($('#editarIvaCliente')[0]),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $("#actualizarIvaCliente").html(
                            "<i class='fa fa-spinner fa-pulse'></i><span class='sr-only'> Actualizando...</span>Actualizando..."
                        );
                        $("#actualizarIvaCliente").attr("disabled", true);
                    },
                    dataType: "json",
                    success: function(data) {
                        $("#actualizarIvaCliente").html("Actualizado");
                        $("#actualizarIvaCliente").removeAttr("disabled");
                        if (data.status == "success") {
                            $('#editarIvaCliente').removeClass('was-validated');
                            location.href = "/iva/clientes"
                        } else if (data.status == "error") {
                            $('#editarIvaCliente').removeClass('was-validated');
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
