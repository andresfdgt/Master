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
                    <h4 class="page-title">Editar rol</h4>
                </div>
                <!--end page-title-box-->
            </div>
            <!--end col-->
        </div>
        <div class="alert icon-custom-alert alert-outline-warning alert-warning-shadow" role="alert">
            <i class="mdi mdi-check-all alert-icon"></i>
            <div class="alert-text">
                <strong>¡Precaución!</strong> Tenga en cuenta que si se modifican los permisos del rol también se editarán
                los permisos de los usuarios que tengan asociado este último en esta empresa.
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <div class="card">
            <div class="card-body">
                <form class="needs-validation" enctype="multipart/form-data" novalidate id="editarRol" method="post">
                    @csrf
                    @method('put')

                    <div class="form-row">
                        <div class="col-md-3 form-group">
                            <label for="validationCustom01">Nombre</label>
                            <input type="hidden" name="id" value="{{ $id }}">
                            <input type="text" class="form-control" name="nombre" value="{{ $nombre }}" required>
                            <div class="invalid-feedback">
                                El nombre es obligatorio!
                            </div>
                        </div>
                    </div>

                    <h4>Permisos</h4>
                    <div class="checkbox my-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="todos_principal"
                                data-parsley-multiple="groups" data-parsley-mincheck="2">
                            <label class="custom-control-label" for="todos_principal">Todos los permisos</label>
                        </div>
                    </div>

                    <ul class="nav nav-tabs" role="tablist">
                        @foreach ($modulos as $key => $modulo)
                            @if ($key == 0)
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#{{ $modulo['nombre'] }}"
                                        role="tab" aria-selected="true">{{ $modulo['nombre'] }}</a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#{{ $modulo['nombre'] }}" role="tab"
                                        aria-selected="true">{{ $modulo['nombre'] }}</a>
                                </li>
                            @endif
                        @endforeach
                    </ul>

                    <div class="tab-content">
                        @foreach ($modulos as $key => $modulo)
                            @if ($key == 0)
                                <div class="tab-pane  active" id="{{ $modulo['nombre'] }}" role="tabpanel">
                                    <div class="form-row mt-2">
                                        @foreach ($modulo['permisos'] as $permisos)
                                            <div class="col-md-3">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="m-0">{{ ucfirst($permisos[0]['name']) }}</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="checkbox my-2">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input todos" grupo="{{ $permisos[0]['name'] }}" id="item{{ $permisos[0]['id'].$permisos[0]['id'] }}" data-parsley-multiple="groups" data-parsley-mincheck="2">
                                                                <label class="custom-control-label" for="item{{ $permisos[0]['id'].$permisos[0]['id'] }}">Todos</label>
                                                            </div>
                                                        </div>
                                                        @for ($i = 0; $i < count($permisos); $i++)
                                                            <div class="checkbox my-2">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input {{ $permisos[0]['name'] }} {{ $permisos[$i]['id'] }}c" name="permisos[]" value="{{ $permisos[$i]['id'] }}" id="item{{ $permisos[$i]['id'] }}" data-parsley-multiple="groups" data-parsley-mincheck="2">
                                                                    <label class="custom-control-label" for="item{{ $permisos[$i]['id'] }}">{{ $permisos[$i]['name'] }}</label>
                                                                </div>
                                                            </div>
                                                        @endfor
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div class="tab-pane" id="{{ $modulo['nombre'] }}" role="tabpanel">
                                    <div class="form-row mt-2">
                                        @foreach ($modulo['permisos'] as $permisos)
                                            <div class="card col-md-3">
                                                <div class="card-header">
                                                    <h5 class="m-0">{{ ucfirst($permisos[0]['name']) }}</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="checkbox my-2">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input todos" grupo="{{ $permisos[0]['name'] }}" id="item{{ $permisos[0]['id'].$permisos[0]['id'] }}" data-parsley-multiple="groups" data-parsley-mincheck="2">
                                                            <label class="custom-control-label" for="item{{ $permisos[0]['id'].$permisos[0]['id'] }}">Todos</label>
                                                        </div>
                                                    </div>
                                                    @for ($i = 0; $i < count($permisos); $i++)
                                                        <div class="checkbox my-2">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input {{ $permisos[0]['name'] }} {{ $permisos[$i]['id'] }}c" name="permisos[]" value="{{ $permisos[$i]['id'] }}" id="item{{ $permisos[$i]['id'] }}" data-parsley-multiple="groups" data-parsley-mincheck="2">
                                                                <label class="custom-control-label" for="item{{ $permisos[$i]['id'] }}">{{ $permisos[$i]['name'] }}</label>
                                                            </div>
                                                        </div>
                                                    @endfor
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach


                        <div class="form-row">
                            <div class="col-md-12 text-center">
                                <button class="btn btn-primary btn-lg" id="actualizarRol" type="submit">Editar
                                    rol</button>
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
    <script>
        var permisos = @json($permisos_roles);
        console.log('permisos: ', permisos);
        $("#editarRol").submit(function(e) {
            e.preventDefault();
            $('#editarRol').addClass('was-validated');
            if ($('#editarRol')[0].checkValidity() === false) {
                event.stopPropagation();
            } else {
                $.ajax({
                    type: "post",
                    url: "/configuracion/roles",
                    data: new FormData($('#editarRol')[0]),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $("#actualizarRol").html(
                            "<i class='fa fa-spinner fa-pulse'></i><span class='sr-only'> Actualizando...</span>Actualizando..."
                        );
                        $("#actualizarRol").attr("disabled", true);
                    },
                    dataType: "json",
                    success: function(data) {
                        $("#actualizarRol").html("Editar rol");
                        $("#actualizarRol").removeAttr("disabled");
                        if (data.status == "success") {
                            $('#editarRol').removeClass('was-validated');
                            $("#editarRol")[0].reset();
                        }
                        Swal.fire({
                            icon: data.status,
                            title: data.title,
                            text: data.message,
                            confirmButtonText: 'OK',
                        }).then((result) => {
                            if (result.value) {
                                if (data.status == "success") {
                                    location.href = "/configuracion"
                                }
                            }
                        });
                    }
                });
            }
        });

        $('.todos').on('change', function() {
            let grupo = $(this).attr("grupo");
            if ($(this).is(':checked')) {
                $("." + grupo + "").prop("checked", true);
            } else {
                $("." + grupo + "").prop("checked", false);
            }
        })
        $('#todos_principal').on('change', function() {
            if ($(this).is(':checked')) {
                $("input[type=checkbox]").prop("checked", true);
            } else {
                $("input[type=checkbox]").prop("checked", false);
            }
        })

        $(document).ready(function() {
            cargarPermisos();
        })

        function cargarPermisos() {
            $("input[type=checkbox]").prop("checked", false);
            permisos.forEach(element => {
                $("." + element.permission_id + "c").prop("checked", true);
            });
        }
    </script>
@endsection
