@extends('layouts.core')
@section('add-head')
    <link href="{{ asset('plugins/dropify/css/dropify.min.css') }}" rel="stylesheet">
@endsection
@section('contenido')
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <h4 class="page-title">Editar categoría</h4>
                </div>
                <!--end page-title-box-->
            </div>
            <!--end col-->
        </div>
        <!-- end page title end breadcrumb -->
        <div class="card">
            <div class="card-body">
                <form class="needs-validation" enctype="multipart/form-data" novalidate id="editarCategoría" method="post">
                    @csrf
                    @method('put')

                    <div class="form-row">
                        <input type="hidden" name="id" value="{{ $categoria->id }}">
                        <div class="col-md-6 form-group">
                            <label for="validationCustom01">Descripción</label>
                            <input type="text" class="form-control" name="descripcion" id="descripcion"
                                value="{{ $categoria->descripcion }}" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="validationCustom01">Slug</label>
                            <input type="text" class="form-control" name="slug" id="slug"
                                value="{{ $categoria->slug }}" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="">Imagen</label>
                            @php
                                $imagen = '';
                                if ($categoria->imagen ?? '' != '') {
                                    $imagen = asset(env('URL_IMAGES') . $categoria->imagen);
                                }
                            @endphp
                            <input type="file" name="imagen" id="input-file-now" class="dropify-es"
                                data-default-file="{{ $imagen }}" />
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="validationCustom01">Orden</label>
                            <input type="text" class="form-control" name="orden" id="orden" required
                                value="{{ $categoria->orden }}" required>
                            <div class="invalid-feedback">
                                ¡El orden es obligatorio!
                            </div>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="">Categoría padre</label>
                            <select name="padre" id="padre" class="form-control">
                                <option value="">Seleccione</option>
                                @foreach ($categorias as $categoriaSelect)
                                    {
                                    <option value="{{ $categoriaSelect->id }}"
                                        {{ $categoria->padre == $categoriaSelect->id ? 'selected' : '' }}>
                                        {{ $categoriaSelect->descripcion }}</option>
                                    }
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <div class="form-row">
                        <div class="checkbox my-2">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="aparece_en_web"
                                    name="aparece_en_web" value="1"
                                    {{ $categoria->aparece_en_web == 1 ? 'checked' : '' }}>
                                <label class="custom-control-label" for="aparece_en_web">Aparece en web</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-12 text-center">
                            <button class="btn btn-primary btn-lg" id="actualizarCategoria" type="submit">Editar
                                categoría</button>
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
    <script>
        $(document).ready(function() {
            $("#descripcion").keypress(function() {
                $("#slug").val(text_to_slug($("#descripcion")
                    .val()))
            })
        });
        $("#editarCategoría").submit(function(e) {
            e.preventDefault();
            $('#editarCategoría').addClass('was-validated');
            if ($('#editarCategoría')[0].checkValidity() === false) {
                event.stopPropagation();
            } else {
                $.ajax({
                    type: "post",
                    url: "/categorias",
                    data: new FormData($('#editarCategoría')[0]),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $("#actualizarCategoria").html(
                            "<i class='fa fa-spinner fa-pulse'></i><span class='sr-only'> Actualizando...</span>Actualizando..."
                        );
                        $("#actualizarCategoria").attr("disabled", true);
                    },
                    dataType: "json",
                    success: function(data) {
                        $("#actualizarCategoria").html("Actualizado");
                        $("#actualizarCategoria").removeAttr("disabled");
                        if (data.status == "success") {
                            $('#editarCategoría').removeClass('was-validated');
                            location.href = "/categorias"
                        } else if (data.status == "error") {
                            $('#editarCategoría').removeClass('was-validated');
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
