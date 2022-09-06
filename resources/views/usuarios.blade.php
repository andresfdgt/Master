@extends('layouts.core')
@section('add-head')
@endsection
@section('contenido')
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <h4 class="page-title">Usuarios</h4>
                </div>
                <!--end page-title-box-->
            </div>
            <!--end col-->
        </div>
        <!-- end page title end breadcrumb -->

        <div class="row">
            @if (auth()->user()->existPermission(10001))
                <div class="form-group col-md-12">
                    <a href="/usuarios/crear">
                        <button type="button" class="btn btn-primary waves-effect waves-light" _msthash="2770885"
                            _msttexthash="118105">Nuevo usuario</button>
                    </a>
                </div>
            @endif

            @foreach ($usuarios as $usuario)
                @php
                    $eliminar = '';
                    $editar = '';
                    if(auth()->user()->existPermission(10002)){
                      $editar = '<a href="/usuarios/editar/' . $usuario->id . '"><button type="button" class="mr-1 btn-sm btn btn-warning waves-effect waves-light" _msthash="2770885" _msttexthash="118105"><i class="fas fa-edit"></i></button></a>';
                    }
                    
                    if (auth()->user()->id != $usuario->id && $usuario->id != $principal && auth()->user()->existPermission(10003)) {
                        $eliminar = '<button class="btn btn-sm btn-danger eliminar" id="' . $usuario->id . '"><i class="fa fa-fas fa-trash"></i></button>';
                    }
                    if (auth()->user()->id != $usuario->id && $usuario->id != $principal && auth()->user()->existPermission(10004)) {
                        $estado = '<button class="btn btn-sm btn-success estado" estado="0" id="' . $usuario->id . '">Activo</button>';
                        if ($usuario->estado == 0) {
                          $estado = '<button class="btn btn-sm btn-info estado" estado="1" id="' . $usuario->id . '">Inactivo</button>';
                        }
                    } else {
                        $estado = '<button class="btn btn-sm btn-success" disabled>Activo</button>';
                        if ($usuario->estado == 0) {
                          $estado = '<button class="btn btn-sm btn-info" disabled>Inactivo</button>';
                        }
                    }
                    $botones = $editar . $eliminar;
                    
                @endphp

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="avatar-box thumb-xl align-self-center ">
                                    <img src="https://ui-avatars.com/api/?background=random&bold=true&rounded=true&name={{ $usuario->nombre }}"
                                        alt="user" class="rounded-circle thumb-md">
                                </div>
                                <div class="row">
                                    <div class="col-md-5 form-group">
                                        <div class="media-body align-self-center ml-3">
                                            <p class="font-14 font-weight-bold mb-0">{{ $usuario->nombre }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-7 form-group">
                                        <div class="media-body align-self-center ml-3">
                                            <p class="font-14 font-weight-bold mb-0">
                                                <i data-feather="mail"
                                                    class="align-self-center vertical-menu-icon icon-dual-vertical"></i>
                                                <span class="font-14 font-weight-bold mb-0">{{ $usuario->email }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-5 form-group">
                                        <div class="media-body align-self-center ml-3">
                                            <i data-feather="log-in"
                                                class="align-self-center vertical-menu-icon icon-dual-vertical"></i>
                                            <span
                                                class="font-14 font-weight-bold mb-0">{{ $usuario->last_login_at }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-7 form-group">
                                        <div class="media-body align-self-center ml-3">
                                            <p class="font-14 font-weight-bold mb-0">{{ $usuario->created_at }} <span
                                                    class="mb-0 font-12 text-muted">Fecha ingreso</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end media-->
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-6 text-left">
                                    {!! $estado !!}
                                </div>
                                <div class="col-6 text-right">
                                    {!! $botones !!}
                                </div>
                            </div>
                        </div>
                        <!--end card-body-->
                    </div>
                    <!--end card-->
                </div>
            @endforeach
            </>

        </div>
    @endsection
    @section('add-scripts')
        <script>
            $(document).ready(function() {
                cargar();
            });

            function cargar() {
                $.ajax({
                    method: "get",
                    url: "{{ route('usuarios') }}",
                    dataType: "json",
                    success: function(response) {
                        if (response.data != "") {
                            $("#listaUsuarios").html(response.data);
                        } else {
                            $("#listaUsuarios").html(
                                '<div class="col-lg-12" ><div class="card" ><div class="card-body text-center"><h5>No hay usuarios hasta el momento.</h5></div></div></div>'
                            )
                        }
                    }
                });
            }
            $(document).on("click", ".eliminar", function() {
                let id = $(this).attr("id");
                Swal.fire({
                    title: "¿Está seguro de eliminar esta usuario?",
                    text: "¡Si no lo está puede cancelar la acción!",
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'Sí, Eliminar!'
                }).then((result) => {
                    if (result.value) {
                        axios.delete("{{ route('usuarios') }}/" + id)
                            .then(function(response) {
                                var data = response.data
                                Swal.fire({
                                    icon: data.status,
                                    title: data.title,
                                    text: data.message,
                                    confirmButtonText: 'OK',
                                }).then((result) => {
                                    if (result.value) {
                                        if (data.status == "success") {
                                            location.reload();
                                        }
                                    }
                                });
                            })
                    }
                })
            })

            $(document).on("click", ".estado", function() {
                let id = $(this).attr("id");
                let estado = $(this).attr("estado");
                let mensaje = "Activar";
                if (estado == 0) {
                    mensaje = "Inactivar";
                }
                Swal.fire({
                    title: "¿Está seguro de " + mensaje + " este usuario?",
                    text: "¡Si no lo está puede cancelar la acción!",
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'Sí,' + mensaje + '!'
                }).then((result) => {
                    if (result.value) {
                        axios.put("/usuarios/estado", {
                                usuario: id,
                                estado: estado
                            })
                            .then(response => {
                                var data = response.data
                                Swal.fire({
                                    icon: data.status,
                                    title: data.title,
                                    text: data.message,
                                    confirmButtonText: 'OK',
                                }).then((result) => {
                                    if (result.value) {
                                        if (data.status == "success") {
                                            location.reload();
                                        }
                                    }
                                });
                            })
                    }
                })
            })
        </script>
    @endsection
