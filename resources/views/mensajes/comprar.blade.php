@extends('layouts.core')
@section('add-head')
@endsection
@section('contenido')
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <h4 class="page-title">Comprar mensajes SMS</h4>
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
                        <div class="form-group">
                            <button type="button" class="btn btn-primary waves-effect waves-light" _msthash="2770885"
                                _msttexthash="118105" data-toggle="modal" data-target="#modalSolicitudCompra">Nueva solicitud</button>
                        </div>
                        <table id="datatable" class="table table-bordered dt-responsive nowrap table-sm"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Descripción</th>
                                    <th>Total</th>
                                    <th>Moneda</th>
                                    <th>Cantidad mensajes</th>
                                    <th>Estado transacción</th>
                                    <th>Fecha</th>
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
    <div class="modal fade" id="modalSolicitudCompra" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form class="needs-validation" novalidate id="nuevaSolicitud" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="exampleModalLabel">Nueva Solicitud compra</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="col-md-12">
                                <label for="validationCustom01" class="col-md-12">Seleccione paquete</label>
                                <select name="paquete" class="form-control" id="paquete" required>
                                    <option value="">Seleccione</option>
                                    @foreach ($planes as $plan)
                                        <option value="{{$plan->id}}">{{$plan->description}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" id="registrarSolicitud">Solicitar</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
@section('add-scripts')

    <script type="text/javascript" src="https://checkout.epayco.co/checkout.js"></script>

    <script>
        $(document).ready(function() {
            $("#datatable").DataTable({
                "destroy": true,
                "ajax": {
                    url: "{{ route('mensajes.compras') }}"
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
                title: "¿Está seguro de eliminar esta difusión?",
                text: "¡Si no lo está puede cancelar la acción!",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Sí, Eliminar!'
            }).then((result) => {
                if (result.value) {
                    axios.delete("{{ route('difusiones') }}/" + id)
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
        });

        var handler = ePayco.checkout.configure({
            key: '{{$key}}',
            test: true
        });

        $("#nuevaSolicitud").submit(function(e) {
            e.preventDefault();
            $('#nuevaSolicitud').addClass('was-validated');
            if ($('#nuevaSolicitud')[0].checkValidity() === false) {
                event.stopPropagation();
            } else {

                form =  JSON.stringify({
                        id: $("#paquete").val()
                    });

                $.ajax({
                    type: "post",
                    url: "{{ route('mensajes.compras.solicitud') }}",
                    data: form,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        "content-type" : "application/json"
                    },
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $("#registrarSolicitud").html(
                            "<i class='fa fa-spinner fa-pulse'></i><span class='sr-only'> Procesando...</span>Procesando..."
                        );
                        $("#registrarSolicitud").attr("disabled", true);
                    },
                    dataType: "json",
                    success: function(data) {

                        handler.open(data);
                        
                    },error: function(err){
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: err.responseJSON.message
                        });
                    }
                });
            }
        });

        
    </script>
@endsection