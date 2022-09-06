@extends('layouts.core')
@section('contenido')
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <h4 class="page-title">Crear agencia de transporte</h4>
                </div>
                <!--end page-title-box-->
            </div>
            <!--end col-->
        </div>
        <!-- end page title end breadcrumb -->
        <div class="card">
            <div class="card-body">
                <form class="needs-validation" enctype="multipart/form-data" novalidate id="nuevaAgenciaTransporte"
                    method="post">
                    @csrf
                    <div class="form-row">
                        <div class="col-md-6 form-group">
                            <label for="validationCustom01">Descripcion</label>
                            <input type="text" class="form-control" name="descripcion" id="descripcion" required>
                            <div class="invalid-feedback">
                                ¡La descripción es obligatoria!
                            </div>
                        </div>
                        <div class="col-md-3 mt-2 form-group">
                            <div class="checkbox my-2">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="favorito" name="favorito"
                                        value="1">
                                    <label class="custom-control-label" for="favorito">Favorito</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 form-group">
                            <div class="card">
                                <div class="px-4 pt-2">
                                    <h5 class="mb-0">Observaciones</h5>
                                </div>
                                <div class="card-body">
                                    <input type="hidden" name="observaciones" id="observaciones_hidden">
                                    <textarea id="observaciones" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-12 text-center">
                            <button class="btn btn-primary" id="registrarAgenciaTransporte" type="submit">Crear agencia de
                                transporte</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
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
        $("#nuevaAgenciaTransporte").submit(function(e) {
            e.preventDefault();
            $('#nuevaAgenciaTransporte').addClass('was-validated');
            if ($('#nuevaAgenciaTransporte')[0].checkValidity() === false) {
                event.stopPropagation();
            } else {
                $("#observaciones_hidden").val(tinymce.get('observaciones').getContent());
                $.ajax({
                    type: "post",
                    url: "/agencias_transporte",
                    data: new FormData($('#nuevaAgenciaTransporte')[0]),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $("#registrarAgenciaTransporte").html(
                            "<i class='fa fa-spinner fa-pulse'></i><span class='sr-only'> Registrando...</span>Registrando..."
                        );
                        $("#registrarAgenciaTransporte").attr("disabled", true);
                    },
                    dataType: "json",
                    success: function(data) {
                        $("#registrarAgenciaTransporte").html("Registrado");
                        $("#registrarAgenciaTransporte").removeAttr("disabled");
                        if (data.status == "success") {
                            $('#nuevaAgenciaTransporte').removeClass('was-validated');
                            location.href = "/agencias_transporte";
                        } else if (data.status == "error") {
                            $('#nuevaAgenciaTransporte').removeClass('was-validated');
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
