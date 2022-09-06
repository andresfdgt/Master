@extends('layouts.core')
@section('add-head')
    <link href="{{ asset('plugins/dropify/css/dropify.min.css') }}" rel="stylesheet">
@endsection
@section('contenido')
    <div class="container-fluid" id="usuarios_app">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <h4 class="page-title">Editar usuario</h4>
                </div>
                <!--end page-title-box-->
            </div>
            <!--end col-->
        </div>
        <!-- end page title end breadcrumb -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form class="needs-validation" enctype="multipart/form-data" novalidate id="editarUsuario"
                            method="post">
                            @csrf
                            @method('put')
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="validationCustom01">Nombre</label>
                                    <input type="text" class="form-control" name="nombre" value="{{ $usuario->nombre }}"
                                        required>
                                    <input type="hidden" name="id" value="{{ $usuario->id }}">
                                    <div class="invalid-feedback">
                                        ¡El nombre es obligatorio!
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="validationCustom01">Correo</label>
                                    <input type="text" class="form-control" name="correo" value="{{ $usuario->email }}"
                                        readonly>
                                    <div class="invalid-feedback">
                                        ¡El correo electrónico es obligatorio!
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="validationCustom01">Empresas</label>
                                    <select class="form-control" id="empresas">
                                        <option value="">Seleccione</option>
                                        @foreach ($empresas as $empresa)
                                            <option value="{{ $empresa->id }}">{{ $empresa->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="validationCustom01">Rol</label>
                                    <div class="d-flex">
                                        <select class="form-control" id="roles">
                                            <option value="">Seleccione</option>
                                        </select>
                                        <button class="btn btn-secondary btn-sm" type="button" id="agregar">Agregar</button>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <input type="hidden" name="empresas_roles" id="empresas_roles">
                                    <table class="table table-bordered table-sm">
                                        <thead>
                                            <th>#</th>
                                            <th>Empresa</th>
                                            <th>Rol</th>
                                            <th>*</th>
                                        </thead>
                                        <tbody>
                                            <tr v-if="roles.length == 0">
                                                <td colspan="3" class="text-center">No hay ningun dato hasta ahora</td>
                                            </tr>
                                            <template>
                                                <tr v-for="(rol, index) in roles">
                                                    <td>@{{ index + 1 }}</td>
                                                    <td>@{{ rol.empresa }}</td>
                                                    <td>@{{ rol.rol }}</td>
                                                    <td class="text-center"><i style="cursor: pointer;"
                                                            class="fa fa-trash text-danger" @click="eliminar(index)"></i>
                                                    </td>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 text-center">
                                    <button class="btn btn-primary" id="actualizarUsuario" type="submit">Actualizar
                                        usuario</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!--end card-body-->
                </div>
            </div>
        </div>
        <!--end card-->
        <!--end col-->
        <!--end row-->
    </div><!-- container -->
@endsection
@section('add-scripts')
    <script src="{{ asset('plugins/dropify/js/dropify.min.js') }}"></script>
    <script>
        var vue_app = new Vue({
            el: "#usuarios_app",
            data: {
                roles: []
            },
            methods: {
                eliminar: function(index) {
                    this.roles.splice(index, 1);
                }
            }

        });

        $(document).ready(function() {
            vue_app.roles = @json($empresas_roles);
        })

        $("#editarUsuario").submit(function(e) {
            e.preventDefault();
            $('#editarUsuario').addClass('was-validated');
            if ($('#editarUsuario')[0].checkValidity() === false) {
                event.stopPropagation();
            } else {
                if (vue_app.roles.length == 0) {
                    Swal.fire({
                        icon: "error",
                        title: "Hay un problema",
                        text: "Este usuario debe tener alguna empresa y rol asignado"
                    });
                    return;
                }
                $("#empresas_roles").val(JSON.stringify(vue_app.roles));
                $.ajax({
                    type: "post",
                    url: "/usuarios",
                    data: new FormData($('#editarUsuario')[0]),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $("#actualizarUsuario").html(
                            "<i class='fa fa-spinner fa-pulse'></i><span class='sr-only'> Actualizando...</span>Actualizando..."
                        );
                        $("#actualizarUsuario").attr("disabled", true);
                    },
                    dataType: "json",
                    success: function(data) {
                        $("#actualizarUsuario").html("actualizar orden");
                        $("#actualizarUsuario").removeAttr("disabled");
                        if (data.status == "success") {
                            $('#editarUsuario').removeClass('was-validated');
                            $("#editarUsuario")[0].reset();
                        }
                        Swal.fire({
                            icon: data.status,
                            title: data.title,
                            text: data.message,
                            confirmButtonText: 'OK',
                        }).then((result) => {
                            if (result.value) {
                                if (data.status == "success") {
                                    location.href = "/usuarios"
                                }
                            }
                        });
                    }
                });
            }
        });

        $(document).on("change", "#empresas", function() {
            $.ajax({
                type: "get",
                url: "/empresas/roles/" + $(this).val(),
                dataType: "json",
                success: function(response) {
                    $("#roles").children().remove();
                    $("#roles").append("<option value=''>Seleccione</option>")
                    $("#roles").append("<option value='0'>Administrador</option>")
                    response.forEach(element => {
                        $("#roles").append("<option value='" + element.id + "'>" + element
                            .name + "</option>")
                    });
                }
            });
        })

        $(document).on("click", "#agregar", function() {
            let id_empresa = $("#empresas").val();
            let nombre_empresa = $('#empresas option:selected').html();
            let id_rol = $("#roles").val();
            let nombre_rol = $('#roles option:selected').html();
            if (id_empresa != "" && id_rol != "") {

                let existe = false;
                vue_app.roles.forEach(element => {

                    if ( element.id_empresa == id_empresa) {
                        existe = true;
                    }

                });

                if (existe) {
                    Swal.fire({
                        icon: "error",
                        title: "Hay un problema",
                        text: "Esta empresa ya se encuentra agregada"
                    });
                    return;
                } else {
                    vue_app.roles.push({
                        id_rol: id_rol,
                        rol: nombre_rol,
                        id_empresa: id_empresa,
                        empresa: nombre_empresa
                    })
                }

            } else {
                Swal.fire({
                    icon: "error",
                    title: "Hay un problema",
                    text: "La empresa y el rol no se deben agregar vacio"
                });
            }
        });
    </script>
@endsection
