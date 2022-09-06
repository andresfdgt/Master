@extends('layouts.core')
@section('add-head')
@endsection
@section('contenido')
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <h4 class="page-title">Empresa</h4>
                </div>
                <!--end page-title-box-->
            </div>
            <!--end col-->
        </div>
        <!-- end page title end breadcrumb -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        @if (auth()->user()->existPermission(10052))
                            <div class="form-group">
                                <button type="button" class="btn btn-primary waves-effect waves-light" _msthash="2770885"
                                    _msttexthash="118105" data-toggle="modal" data-target="#modalRegistrarEmpresa">Nueva
                                    empresa</button>
                            </div>
                        @endif
                        <table id="datatable" class="table table-bordered dt-responsive nowrap table-sm"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Nombre</th>
                                    <th>Razón social</th>
                                    <th>Cif</th>
                                    <th>Dirección</th>
                                    <th>Teléfono</th>
                                    <th>Fecha registro</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <!--end card-body-->
                </div>
                <!--end card-->
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>
    <div id="empresas_app">
        <div class="modal fade" id="modalRegistrarEmpresa" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form class="needs-validation" novalidate id="nuevaEmpresa" method="post">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title mt-0" id="exampleModalLabel">Nueva empresa</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="validationCustom01">Nombre</label>
                                    <input type="text" class="form-control" name="nombre" required>
                                    <div class="invalid-feedback">
                                        ¡El nombre es obligatorio!
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="validationCustom01">Razon solcial</label>
                                    <input type="text" class="form-control" name="razon_social" required>
                                    <div class="invalid-feedback">
                                        ¡La Razon solcial es obligatoria!
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="validationCustom01">Cif</label>
                                    <input type="text" class="form-control" name="cif" required>
                                    <div class="invalid-feedback">
                                        ¡Cif es obligatorio!
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="validationCustom01">Email</label>
                                    <input type="email" class="form-control" name="email" required>
                                    <div class="invalid-feedback">
                                        Email es obligatorio!
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="validationCustom01">Dirección</label>
                                    <input type="text" class="form-control" name="direccion" required>
                                    <div class="invalid-feedback">
                                        ¡La dirección es obligatoria!
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="validationCustom01">Teléfono</label>
                                    <input type="text" class="form-control" name="telefono" required>
                                    <div class="invalid-feedback">
                                        ¡El teléfono es obligatorio!
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="validationCustom01">País</label>
                                    <input type="text" class="form-control" name="pais" required>
                                    <div class="invalid-feedback">
                                        ¡El país es obligatorio!
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="validationCustom01">Codigo postal</label>
                                    <input type="text" class="form-control" name="codigo_postal" required>
                                    <div class="invalid-feedback">
                                        ¡La localidad es obligatoria!
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="validationCustom01">Localidad</label>
                                    <input type="text" class="form-control" name="localidad" required>
                                    <div class="invalid-feedback">
                                        ¡La localidad es obligatoria!
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="validationCustom01">Contacto</label>
                                    <input type="text" class="form-control" name="contacto" required>
                                    <div class="invalid-feedback">
                                        ¡El contacto es obligatorio!
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="validationCustom01">Modulos</label>
                                    <input type="hidden" name="modulos" id="input_modulos_store">

                                    <div class="d-flex">
                                        <select class="form-control" id="modulos_store">
                                            <option value="">Seleccione</option>
                                            @foreach ($modulos as $modulo)
                                                <option value="{{ $modulo->id }}">{{ $modulo->nombre }}</option>
                                            @endforeach
                                        </select>
                                        <button class="btn btn-secondary btn-sm" id="agregar_store"
                                            type="button">Agregar</button>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <table class="table table-bordered table-sm">
                                        <thead>
                                            <th>#</th>
                                            <th>Nombre</th>
                                            <th>*</th>
                                        </thead>
                                        <tbody>
                                            <tr v-if="modulos_vue_store.length == 0">
                                                <td colspan="3" class="text-center">No hay ningun modulo hasta ahora</td>
                                            </tr>
                                            <template>
                                                <tr v-for="(modulo, index) in modulos_vue_store">
                                                    <td>@{{ index + 1 }}</td>
                                                    <td>@{{ modulo.nombre }}</td>
                                                    <td>
                                                        <button class="btn btn-danger btn-sm eliminar_store" :id="index" type="button"><i class="fa fa-fas fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary" id="registrarEmpresa">Registrar empresa</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <div class="modal fade" id="modalActualizarEmpresa" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form class="needs-validation" novalidate id="editarEmpresa" method="post">
                        @csrf
                        @method("put")
                        <div class="modal-header">
                            <h5 class="modal-title mt-0" id="exampleModalLabel">Actualizar empresa</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="validationCustom01">Nombre</label>
                                    <input type="text" class="form-control" name="nombre" id="nombre" required>
                                    <input type="hidden" name="id" id="editar_id">
                                    <div class="invalid-feedback">
                                        ¡El nombre es obligatorio!
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="validationCustom01">Razon solcial</label>
                                    <input type="text" class="form-control" name="razon_social" id="razon_social"
                                        required>
                                    <div class="invalid-feedback">
                                        ¡La Razon solcial es obligatoria!
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="validationCustom01">Cif</label>
                                    <input type="text" class="form-control" name="cif" id="cif" required>
                                    <div class="invalid-feedback">
                                        ¡Cif es obligatorio!
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="validationCustom01">Email</label>
                                    <input type="email" class="form-control" name="email" id="email" required>
                                    <div class="invalid-feedback">
                                        Email es obligatorio!
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="validationCustom01">Dirección</label>
                                    <input type="text" class="form-control" name="direccion" id="direccion" required>
                                    <div class="invalid-feedback">
                                        ¡La dirección es obligatoria!
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="validationCustom01">Teléfono</label>
                                    <input type="text" class="form-control" name="telefono" id="telefono" required>
                                    <div class="invalid-feedback">
                                        ¡El teléfono es obligatorio!
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="validationCustom01">País</label>
                                    <input type="text" class="form-control" name="pais" id="pais" required>
                                    <div class="invalid-feedback">
                                        ¡El país es obligatorio!
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="validationCustom01">Codigo postal</label>
                                    <input type="text" class="form-control" name="codigo_postal" id="codigo_postal"
                                        required>
                                    <div class="invalid-feedback">
                                        ¡La localidad es obligatoria!
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="validationCustom01">Localidad</label>
                                    <input type="text" class="form-control" name="localidad" id="localidad" required>
                                    <div class="invalid-feedback">
                                        ¡La localidad es obligatoria!
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="validationCustom01">Contacto</label>
                                    <input type="text" class="form-control" name="contacto" id="contacto" required>
                                    <div class="invalid-feedback">
                                        ¡El contacto es obligatorio!
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="validationCustom01">Modulos</label>
                                    <input type="hidden" name="modulos" id="input_modulos_update">
                                    <div class="d-flex">
                                        <select class="form-control" id="modulos_update">
                                            <option value="">Seleccione</option>
                                            @foreach ($modulos as $modulo)
                                                <option value="{{ $modulo->id }}">{{ $modulo->nombre }}</option>
                                            @endforeach
                                        </select>
                                        <button class="btn btn-secondary btn-sm" id="agregar_update"
                                            type="button">Agregar</button>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <table class="table table-bordered table-sm">
                                        <thead>
                                            <th>#</th>
                                            <th>Nombre</th>
                                            <th>*</th>
                                        </thead>
                                        <tbody>
                                            <tr v-if="modulos_vue_update.length == 0">
                                                <td colspan="3" class="text-center">No hay ningun modulo hasta ahora
                                                </td>
                                            </tr>
                                            <template>
                                                <tr v-for="(modulo, index) in modulos_vue_update">
                                                    <td>@{{ index + 1 }}</td>
                                                    <td>@{{ modulo.nombre }}</td>
                                                    <td><button class="btn btn-danger btn-sm eliminar_update" :id="index"
                                                            type="button"><i class="fa fa-fas fa-trash"></i></button></i>
                                                    </td>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary" id="actualizarEmpresa">Actualizar
                                empresa</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <div class="modal fade" id="modalUsuarios" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="exampleModalLabel">Usuarios de la empresa</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered table-sm">
                            <thead>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Estado</th>
                                <th>Rol</th>
                            </thead>
                            <tbody>
                                <tr v-if="usuarios.length == 0">
                                    <td colspan="5" class="text-center">No hay ningun usuario hasta ahora
                                    </td>
                                </tr>
                                <template>
                                    <tr v-for="(usuario, index) in usuarios">
                                        <td>@{{ index + 1 }}</td>
                                        <td>@{{ usuario.nombre }}</td>
                                        <td>@{{ usuario.email }}</td>
                                        <td>@{{ usuario.estado }}</td>
                                        <td>@{{ usuario.rol }}</td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('add-scripts')
    <script>
        var vue_app_empresas = new Vue({
            el: "#empresas_app",
            data: {
                modulos_vue_store: [],
                modulos_vue_update: [],
                usuarios: []
            }

        });
        $(document).ready(function() {
            $("#datatable").DataTable({
                "destroy": true,
                "ajax": {
                    url: "{{ route('empresas') }}"
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
        $(document).on("click", ".eliminar", function() {
            let id = $(this).attr("id");
            Swal.fire({
                title: "¿Está seguro de eliminar esta empresa?",
                text: "¡Si no lo está puede cancelar la acción!",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Sí, Eliminar!'
            }).then((result) => {
                if (result.value) {
                    axios.delete("{{ route('empresas') }}/" + id)
                        .then(function(response) {
                            $("#datatable").DataTable().ajax.reload();
                            var data = response.data
                            Swal.fire({
                                icon: data.status,
                                title: data.title,
                                text: data.message,
                            });
                        })
                }
            })
        })
        $("#nuevaEmpresa").submit(function(e) {
            e.preventDefault();
            $('#nuevaEmpresa').addClass('was-validated');
            if ($('#nuevaEmpresa')[0].checkValidity() === false) {
                event.stopPropagation();
            } else {
                $("#input_modulos_store").val(JSON.stringify(vue_app_empresas.modulos_vue_store));
                $.ajax({
                    type: "post",
                    url: "{{ route('empresas.store') }}",
                    data: new FormData($('#nuevaEmpresa')[0]),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $("#registrarEmpresa").html(
                            "<i class='fa fa-spinner fa-pulse'></i><span class='sr-only'> Registrando...</span>Registrando..."
                        );
                        $("#registrarEmpresa").attr("disabled", true);
                    },
                    dataType: "json",
                    success: function(data) {
                        $("#registrarEmpresa").html("Registrar empresa");
                        $("#registrarEmpresa").removeAttr("disabled");
                        if (data.status == "success") {
                            $('#nuevaEmpresa').removeClass('was-validated');
                            $("#datatable").DataTable().ajax.reload();
                            $("#modalRegistrarEmpresa").modal("hide");
                            $("#nuevaEmpresa")[0].reset();
                        }
                        Swal.fire({
                            icon: data.status,
                            title: data.title,
                            text: data.message
                        });
                    }
                });
            }
        });
        $(document).on("click", ".editar", function() {
            $.ajax({
                type: "get",
                url: "{{ route('empresas') }}/" + $(this).attr("id"),
                dataType: "json",
                success: function(response) {
                    $("#nombre").val(response.nombre);
                    $("#razon_social").val(response.razon_social);
                    $("#cif").val(response.cif);
                    $("#direccion").val(response.direccion);
                    $("#pais").val(response.pais);
                    $("#codigo_postal").val(response.codigo_postal);
                    $("#localidad").val(response.localidad);
                    $("#telefono").val(response.telefono);
                    $("#telefono_2").val(response.telefono);
                    $("#email").val(response.email);
                    $("#contacto").val(response.contacto);
                    $("#editar_id").val(response.id);
                    vue_app_empresas.modulos_vue_update = response.modulos;
                    $("#modalActualizarEmpresa").modal("show");
                }
            });
        })
        $("#editarEmpresa").submit(function(e) {
            e.preventDefault();
            $('#editarEmpresa').addClass('was-validated');
            if ($('#editarEmpresa')[0].checkValidity() === false) {
                event.stopPropagation();
            } else {
                $("#input_modulos_update").val(JSON.stringify(vue_app_empresas.modulos_vue_update));
                $.ajax({
                    type: "post",
                    url: "{{ route('empresas.update') }}",
                    data: new FormData($('#editarEmpresa')[0]),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $("#actualizarEmpresa").html(
                            "<i class='fa fa-spinner fa-pulse'></i><span class='sr-only'>\&nbspActualizando...</span>Actualizando..."
                        );
                        $("#actualizarEmpresa").attr("disabled", true);
                    },
                    dataType: "json",
                    success: function(data) {
                        $("#actualizarEmpresa").html("Actualizar empresa");
                        $("#actualizarEmpresa").removeAttr("disabled");
                        if (data.status == "success") {
                            $('#editarEmpresa').removeClass('was-validated');
                            $("#modalActualizarEmpresa").modal("hide");
                            $("#datatable").DataTable().ajax.reload();
                        }
                        Swal.fire({
                            icon: data.status,
                            title: data.title,
                            text: data.message
                        });
                        location.reload();
                    }
                });
            }
        });

        $(document).on("click", "#agregar_store", function() {
            let id_modulo = $("#modulos_store").val();
            let nombre_modulo = $('#modulos_store option:selected').html();
            if (id_modulo != "") {
                if (!vue_app_empresas.modulos_vue_store.find(modulo => modulo.id === id_modulo)) {
                    vue_app_empresas.modulos_vue_store.push({
                        id: id_modulo,
                        nombre: nombre_modulo
                    })
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Hay un problema",
                        text: "Este modulo ya se encuentra agregado"
                    });
                }
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Hay un problema",
                    text: "El modulo no se debe agregar vacio"
                });
            }
        });
        $(document).on("click", "#agregar_update", function() {
            let id_modulo = $("#modulos_update").val();
            let nombre_modulo = $('#modulos_update option:selected').html();
            if (id_modulo != "") {
                if (!vue_app_empresas.modulos_vue_update.find(modulo => modulo.id == id_modulo)) {
                    vue_app_empresas.modulos_vue_update.push({
                        id: id_modulo,
                        nombre: nombre_modulo
                    })
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Hay un problema",
                        text: "Este modulo ya se encuentra agregado"
                    });
                }
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Hay un problema",
                    text: "El modulo no se debe agregar vacio"
                });
            }
        });

        $(document).on("click", ".eliminar_store", function() {
            vue_app_empresas.modulos_vue_store.splice($(this).attr("id"), 1);
        })

        $(document).on("click", ".eliminar_update", function() {
            vue_app_empresas.modulos_vue_update.splice($(this).attr("id"), 1);
        })

        $(document).on("click", ".estado", function() {
            let estado = $(this).attr("estado");
            let nombre_estado = (estado == 1) ? "Activar" : "Inactivar";
            let id = $(this).attr("id");
            Swal.fire({
                title: "¿Está seguro de " + nombre_estado + " esta empresa?",
                text: "¡Si no lo está puede cancelar la acción!",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Sí, ' + nombre_estado + '!'
            }).then((result) => {
                if (result.value) {
                    axios.put("{{ route('empresas.estado') }}", {
                            id: id,
                            estado: estado
                        })
                        .then(function(response) {
                            $("#datatable").DataTable().ajax.reload();
                            var data = response.data
                            Swal.fire({
                                icon: data.status,
                                title: data.title,
                                text: data.message,
                            });
                        })
                }
            })
        })

        $(document).on("click", ".usuarios", function() {
            $.ajax({
                type: "get",
                url: "/empresas/usuarios/" + $(this).attr("id"),
                dataType: "json",
                success: function(response) {
                    vue_app_empresas.usuarios = response;
                    $("#modalUsuarios").modal("show");
                }
            });
        })
    </script>
@endsection
