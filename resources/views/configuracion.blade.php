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
                    <h4 class="page-title">Configuración</h4>
                </div>
                <!--end page-title-box-->
            </div>
            <!--end col-->
        </div>
        <div>
            <ul class="nav nav-tabs" role="tablist">
                @if (auth()->user()->existPermission(10201))
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#general" role="tab"
                            aria-selected="true">General</a>
                    </li>
                @endif

                @if (auth()->user()->existPermission(10101))
                    <li class="nav-item">
                        <a class="nav-link " data-toggle="tab" href="#roles" role="tab" aria-selected="true">Roles</a>
                    </li>
                @endif

            </ul>
            <div class="tab-content">
                @if (auth()->user()->existPermission(10201))
                    <div class="tab-pane  active" id="general" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h4>Datos de parametrización</h4>
                            </div>
                            <div class="card-body">

                                <form class="needs-validation" enctype="multipart/form-data" novalidate id="configuracion"
                                    method="post">
                                    @csrf
                                    @method('put')
                                    <div class="row">
                                        <div class="col-md-2 mb-3">
                                            <label for="">Formato de fecha</label>
                                            <select name="formato_fecha" id="formato_fecha" class="form-control" required>
                                                <option value="">Seleccione</option>
                                                <option value="Y-m-d">1930-08-05</option>
                                                <option value="d-m-Y">05-08-1930</option>
                                                <option value="d/m/y">05/08/30</option>
                                                <option value="y/m/d">30/08/05</option>
                                                <option value="d-F-Y">05-agosto-1930</option>
                                                <option value="d-M-Y">05-agos-1930</option>
                                                <option value="d-M-y">05-agos-30</option>
                                                <option value="Y-M-d">1930-agos-05</option>
                                                <option value="y-M-d">30-agos-05</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                ¡El formato de fecha es obligatorio!
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label for="">País</label>
                                            <select name="pais" class="form-control" required>
                                                <option value="">Seleccione</option>
                                                @foreach ($paises as $pais)
                                                    @php
                                                        $selected = '';
                                                        if ($configuracion->pais_id == $pais->id) {
                                                            $selected = 'selected';
                                                        }
                                                    @endphp
                                                    <option {{ $selected }} value="{{ $pais->id }}">
                                                        {{ $pais->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                ¡El formato de fecha es obligatorio!
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label for="">Número de decimales</label>
                                            <input type="number" class="form-control" name="decimales"
                                                value="{{ $configuracion->decimales }}" required>
                                            <div class="invalid-feedback">
                                                ¡El formato de fecha es obligatorio!
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="">Logo</label>
                                            @php
                                                $logo = '';
                                                if ($configuracion->logo ?? '' != '') {
                                                    $logo = asset(env('URL_IMAGES') . $configuracion->logo);
                                                }
                                            @endphp
                                            <input type="file" name="logo" id="input-file-now" class="dropify-es"
                                                data-default-file="{{ $logo }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-center">
                                        <button class="btn btn-primary btn-lg" type="submit"
                                            id="actualizarConfiguracion">Actualizar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif

                @if (auth()->user()->existPermission(10101))
                    <div class="tab-pane" id="roles" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                @if (auth()->user()->existPermission(10102))
                                    <div class="form-group">
                                        <a href="configuracion/roles/crear"><button type="button"
                                                class="btn btn-primary waves-effect waves-light" _msthash="2770885"
                                                _msttexthash="118105" data-toggle="modal"
                                                data-target="#modalRegistrarEmpresa">Nuevo
                                                rol</button></a>
                                    </div>
                                @endif
                                <div class="table-responsive">
                                    <table id="datatableRoles" class="table table-bordered dt-responsive nowrap table-sm"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>Nombre</th>
                                                <th>Fecha registro</th>
                                                <th>Estado</th>
                                                <th>Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif



            </div>
        </div>
        <!-- end page title end breadcrumb -->

        <!--end card-->
        <!--end col-->
        <!--end row-->
    </div><!-- container -->
@endsection
@section('add-scripts')
    <script src="{{ asset('plugins/dropify/js/dropify.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#formato_fecha").val("{{ $configuracion->formato_fecha }}")
            $("#datatableRoles").DataTable({
                "destroy": true,
                "ajax": {
                    url: "{{ route('configuracion.roles') }}"
                },
                "deferRender": true,
                "retrieve": true,
                "processing": true,
                "responsive": true,
                "language": {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                }
            });
        });

        $("#configuracion").submit(function(e) {
            e.preventDefault();
            if ($('#configuracion')[0].checkValidity() === false) {
                event.stopPropagation();
            } else {
                $.ajax({
                    type: "post",
                    url: "/configuracion",
                    data: new FormData($('#configuracion')[0]),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $("#actualizarConfiguracion").html(
                            "<i class='fa fa-spinner fa-pulse'></i><span class='sr-only'> Actualizando...</span>Actualizando..."
                        );
                        $("#actualizarConfiguracion").attr("disabled", true);
                    },
                    dataType: "json",
                    success: function(data) {
                        $("#actualizarConfiguracion").html("Actualizar");
                        $("#actualizarConfiguracion").removeAttr("disabled");
                        if (data.status == "success") {
                            $('#nuevoOrden').removeClass('was-validated');
                        }
                        Swal.fire({
                            icon: data.status,
                            title: data.title,
                            text: data.message
                        })
                    }
                });
            }
            $('#configuracion').addClass('was-validated');
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
