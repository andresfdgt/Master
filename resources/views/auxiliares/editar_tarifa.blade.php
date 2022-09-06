@extends('layouts.core')
@section('contenido')
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-6">
                <div class="page-title-box">
                    <h4 class="page-title">Editar tarifa</h4>
                </div>
                <!--end page-title-box-->
            </div>
            <div class="col-sm-6">
                <a href="{{ url('/tarifas') }}" class="col-sm-6 text-right">
                    <button class="btn btn-primary">Volver</button>
                </a>
            </div>
            <!--end col-->
        </div>
        <!-- end page title end breadcrumb -->
        <div class="card">
            <div class="card-body">
                <form class="needs-validation" enctype="multipart/form-data" novalidate id="editarTarifa" method="post">
                    @csrf
                    @method('put')

                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">Descripción</label>
                            <input type="hidden" name="id" value="{{ $tarifa->id }}">
                            <input type="text" class="form-control" name="descripcion"
                                value="{{ $tarifa->descripcion }}" required>
                            <div class="invalid-feedback">
                                ¡La descripción es obligatoria!
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                            <label for="tipo_tarifa">Tipo de tarifa</label>
                            <select name="tipo" id="tipo_tarifa" class="form-control" required>
                                <option value="%dcto" {{ $tarifa->tipo == "%dcto" ? 'selected' : '' }}>% Descuento sobre precio base</option>
                                <option value="importe" {{ $tarifa->tipo == "importe" ? 'selected' : '' }}>Importe</option>
                                <option value="%incr" {{ $tarifa->tipo == "%incr" ? 'selected' : '' }}>% Incremento sobre coste</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                            <label for="tipo_tarifa">Valor</label>
                            <input type="number" step="0.001" id="valor" name="valor" value="{{ $tarifa->valor }}" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <div class="checkbox my-2">
                                <div class="custom-control custom-checkbox">
                                    @php
                                        if ($tarifa->ivaincluido == 'si') $ivaincl = 1;
                                        else $ivaincl = 0;
                                    @endphp
                                    <input type="checkbox" class="custom-control-input" name="ivaincluido"
                                        value="1" {{ $ivaincl == 1 ? 'checked' : '' }}  id="ivaincluido">
                                    <label class="custom-control-label" for="ivaincluido">IVA incluido</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12">
                            <label for="">Observaciones</label>
                            <div class="card">
                                <div class="card-body">
                                    <input type="hidden" name="observaciones" id="observaciones_hidden">
                                    <textarea id="observaciones" cols="30" rows="10">{{ $tarifa->observaciones }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-12 text-center">
                            <button class="btn btn-primary btn-lg" id="actualizarTarifa" type="submit">Editar tarifa</button>
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
        $("#editarTarifa").submit(function(e) {
            e.preventDefault();
            $('#editarTarifa').addClass('was-validated');
            if ($('#editarTarifa')[0].checkValidity() === false) {
                event.stopPropagation();
            } else {
                $("#observaciones_hidden").val(tinymce.get('observaciones').getContent());
                $.ajax({
                    type: "post",
                    url: "/tarifas",
                    data: new FormData($('#editarTarifa')[0]),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $("#actualizarTarifa").html(
                            "<i class='fa fa-spinner fa-pulse'></i><span class='sr-only'> Actualizando...</span>Actualizando..."
                        );
                        $("#actualizarTarifa").attr("disabled", true);
                    },
                    dataType: "json",
                    success: function(data) {
                        $("#actualizarTarifa").html("Actualizado");
                        $("#actualizarTarifa").removeAttr("disabled");
                        if (data.status == "success") {
                            $('#editarTarifa').removeClass('was-validated');
                            location.href = "/tarifas"
                        } else if (data.status == "error") {
                            $('#editarTarifa').removeClass('was-validated');
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
