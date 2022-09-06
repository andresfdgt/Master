@extends('layouts.core')
@section('add-head')
    <link href="{{ asset('plugins/dropify/css/dropify.min.css') }}" rel="stylesheet">
@endsection
@section('contenido')
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-6">
                <div class="page-title-box">
                    <h4 class="page-title">Editar marca</h4>
                </div>
                <!--end page-title-box-->
            </div>
            <div class="col-sm-6">
                <a href="{{ url('/marcas') }}" class="col-sm-6 text-right">
                    <button class="btn btn-primary">Volver</button>
                </a>
            </div>
            <!--end col-->
        </div>
        <!-- end page title end breadcrumb -->
        <div class="card">
            <div class="card-body">
                <form class="needs-validation" enctype="multipart/form-data" novalidate id="editarMarca" method="post">
                    @csrf
                    @method('put')

                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">Descripción</label>
                            <input type="hidden" name="id" value="{{ $marca->id }}">
                            <input type="text" class="form-control" name="descripcion"
                                value="{{ $marca->descripcion }}" required>
                            <div class="invalid-feedback">
                                ¡La descripción es obligatoria!
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="">Imagen</label>
                            @php
                                $imagen = '';
                                if ($marca->imagen ?? '' != '') {
                                    $imagen = asset(env('URL_IMAGES') . $marca->imagen);
                                }
                            @endphp
                            <input type="file" name="imagen" id="input-file-now" class="dropify-es"
                                data-default-file="{{ $imagen }}" />
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12">
                            <label for="">Observaciones</label>
                            <div class="card">
                                <div class="card-body">
                                    <input type="hidden" name="observaciones" id="observaciones_hidden">
                                    <textarea id="observaciones" cols="30" rows="10">{{ $marca->observaciones }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="checkbox my-2">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="favorito" name="favorito"
                                    value="1" {{ $marca->favorito == 1 ? 'checked' : '' }}>
                                <label class="custom-control-label" for="favorito">Favorito</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-12 text-center">
                            <button class="btn btn-primary btn-lg" id="actualizarMarca" type="submit">Editar marca</button>
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
    <script src="{{ asset('plugins/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ asset('js/functions.js') }}"></script>
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
        $("#editarMarca").submit(function(e) {
            e.preventDefault();
            $('#editarMarca').addClass('was-validated');
            if ($('#editarMarca')[0].checkValidity() === false) {
                event.stopPropagation();
            } else {
                $("#observaciones_hidden").val(tinymce.get('observaciones').getContent());
                $.ajax({
                    type: "post",
                    url: "/marcas",
                    data: new FormData($('#editarMarca')[0]),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $("#actualizarMarca").html(
                            "<i class='fa fa-spinner fa-pulse'></i><span class='sr-only'> Actualizando...</span>Actualizando..."
                        );
                        $("#actualizarMarca").attr("disabled", true);
                    },
                    dataType: "json",
                    success: function(data) {
                        $("#actualizarMarca").html("Actualizado");
                        $("#actualizarMarca").removeAttr("disabled");
                        if (data.status == "success") {
                            $('#editarMarca').removeClass('was-validated');
                            location.href = "/marcas"
                        } else if (data.status == "error") {
                            $('#editarMarca').removeClass('was-validated');
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
        $(function() {
            // Basic
            $('.dropify').dropify();

            // Translated
            $('.dropify-es').dropify({
                messages: {
                    default: 'Arrastra una imagen aquí o selecciona',
                    replace: 'Arrastra o selecciona para reemplazar',
                    remove: 'Eliminar',
                    error: 'El archivo es demasiado grande'
                }
            });

            // Used events
            var drEvent = $('#input-file-events').dropify();

            drEvent.on('dropify.beforeClear', function(event, element) {
                return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
            });

            drEvent.on('dropify.afterClear', function(event, element) {
                alert('File deleted');
            });

            drEvent.on('dropify.errors', function(event, element) {
                console.log('Has Errors');
            });

            var drDestroy = $('#input-file-to-destroy').dropify();
            drDestroy = drDestroy.data('dropify')
            $('#toggleDropify').on('click', function(e) {
                e.preventDefault();
                if (drDestroy.isDropified()) {
                    drDestroy.destroy();
                } else {
                    drDestroy.init();
                }
            })
        });
    </script>
@endsection
