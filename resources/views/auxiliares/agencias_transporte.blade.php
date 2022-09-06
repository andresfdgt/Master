@extends('layouts.core')
@section('contenido')
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <h4 class="page-title">Agencias de transporte</h4>
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
                        @if (auth()->user()->existPermission(10252))
                            <div class="form-group">
                                <a href="agencias_transporte/crear"><button type="button"
                                        class="btn btn-primary waves-effect waves-light" _msthash="2770885"
                                        _msttexthash="118105" data-toggle="modal"
                                        data-target="#modalRegistrarAgenciaTransporte">Nueva agencia de
                                        transporte</button></a>
                            </div>
                        @endif
                        <table id="datatableAgenciasTransporte" class="table table-bordered dt-responsive nowrap table-sm"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="col-1">Item</th>
                                    <th class="col-1">Favorito</th>
                                    <th>Descripción</th>
                                    <th class="col-2">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->
    </div><!-- container -->
@endsection
@section('add-scripts')
    <script>
        $(document).ready(function() {
            $("#datatableAgenciasTransporte").DataTable({
                "destroy": true,
                "ajax": {
                    url: "{{ route('agencias_transporte.agencias_transporte') }}"
                },
                'columnDefs': [{
                    "targets": 1,
                    "className": "text-center"
                }],
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
            $(document).on("click", ".eliminar", function() {
                let id = $(this).attr("id");
                Swal.fire({
                    title: "¿Está seguro de eliminar esta agencia de transporte?",
                    text: "¡Si no lo está puede cancelar la acción!",
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'Sí, ¡eliminar!'
                }).then((result) => {
                    if (result.value) {
                        axios.delete("{{ route('agencias_transporte') }}/" + id)
                            .then(function(response) {
                                var data = response.data
                                if (data.status == "success") {
                                    location.reload();
                                }
                            })
                    }
                })
            })
        });
    </script>
@endsection
