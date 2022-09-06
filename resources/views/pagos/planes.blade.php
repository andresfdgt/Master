@extends('layouts.core')
@section('add-head')
@endsection
@section('contenido')

<div class="container-fluid" id="app">

    <div class="mt-4">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-outline-secondary active">
                                <input type="radio" name="btnradio" id="btnradio1" autocomplete="off"  value="1" v-model="seleccionado"> Mensual
                            </label>
                            <label class="btn btn-outline-secondary">
                                <input type="radio" name="btnradio" id="btnradio2" autocomplete="off" value="6" v-model="seleccionado"> Semestral
                            </label>
                            <label class="btn btn-outline-secondary">
                                <input type="radio" name="btnradio" id="btnradio2" autocomplete="off" value="12" v-model="seleccionado"> Anual
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <div class="row">

        <template v-for="(item,index) in planes">

            <template v-if="item.meses === parseInt(seleccionado) ">
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body">                
                            <div class="pricingTable1 text-center">
                                <h6 class="title1 py-2 m-0">@{{item.nombre}}</h6>
                                {{-- <p class="text-muted p-3 mb-0">@{{item.descripcion}}</p> --}}
                                <div class="px-2 py-2 m-2">
                                    <h3 class="amount amount-border d-inline-block">$@{{item.precio_usd}} USD</h3>
                                    <small class="font-12 text-muted">/mes</small>
                                </div>
                                <hr class="hr-dashed">
                                <ul class="list-unstyled pricing-content-2 text-left py-2 border-0 mb-0">
                                    <li>Hasta @{{item.miembros}} miembros</li>
                                    <li>@{{parseInt(item.miembros/10)}} células</li>
                                    <li>App móvil</li>
                                </ul>
                                <button type="submit" :id="index" @click="comprar(item.id, index)" class="btn btn-dark py-2 px-5 font-16 registrarSolicitud"><span>Comprar</span></button>
                            </div>
                            <!--end pricingTable-->
                        </div>
                        <!--end card-body-->
                    </div>
                    <!--end card-->
                </div>
            </template>
        </template>
    </div>
</div>
@endsection
@section('add-scripts')

    <script type="text/javascript" src="https://checkout.epayco.co/checkout.js"></script>

    <script>
        var handler = ePayco.checkout.configure({
            key: '{{$key}}',
            test: true
        });

        var app = new Vue({
            el: '#app',
            data: {
                seleccionado: "1",
                planes: @json($planes)
            },
            methods: {
                comprar: function (id, id_button) {

                    form =  JSON.stringify({
                        id: id
                    });

                    $.ajax({
                        type: "post",
                        url: "{{ route('pagos.solicitud') }}",
                        data: form,
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                            "content-type" : "application/json"
                        },
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend: function() {
                            $(`#${id_button}`).html(
                                "<i class='fa fa-spinner fa-pulse'></i><span class='sr-only'> Procesando...</span>Procesando..."
                            );
                            $(`#${id_button}`).attr("disabled", true);
                        },
                        dataType: "json",
                        success: function(data) {

                            handler.open(data);
                            
                        },error: function(err){

                            $(`#${id_button}`).html(
                                "Comprar"
                            );                            

                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: err.responseJSON.message
                            });
                        }
                    });
                }
            }
        })

        $(document).on("change","input[type='radio']",function () { 
            app.seleccionado=$(this).val();
         })
    </script>
@endsection
