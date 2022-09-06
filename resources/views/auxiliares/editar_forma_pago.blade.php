@extends('layouts.core')
@section('contenido')
    <div class="container-fluid" id="formas_pago_app">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <h4 class="page-title">Editar forma de pago</h4>
                </div>
                <!--end page-title-box-->
            </div>
            <!--end col-->
        </div>
        <!-- end page title end breadcrumb -->
        <div class="card">
            <div class="card-body">
                <form class="needs-validation" enctype="multipart/form-data" novalidate id="editarFormaPago" method="post">
                    @csrf
                    @method('put')
                    <input type="hidden" name="forma_pago_id" v-model="formaPago">

                    <div class="form-row">
                        <div class="col-md-3 form-group">
                            <label for="validationCustom01">Descripción</label>
                            <input type="hidden" name="id" id="forma_pago_id" value="{{ $formaPago->id }}">
                            <input type="text" class="form-control" name="descripcion"
                                value="{{ $formaPago->descripcion }}" required>
                            <div class="invalid-feedback">
                                ¡La descripción es obligatoria!
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="checkbox my-2">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="favorito" name="favorito"
                                    value="1" {{ $formaPago->favorito == 1 ? 'checked' : '' }}>
                                <label class="custom-control-label" for="favorito">Favorito</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="checkbox my-2">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="remesable" name="remesable"
                                    value="1" {{ $formaPago->remesable == 1 ? 'checked' : '' }}>
                                <label class="custom-control-label" for="remesable">Remesable</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="checkbox my-2">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="a_cartera" name="a_cartera"
                                    value="1" {{ $formaPago->a_cartera == 1 ? 'checked' : '' }}>
                                <label class="custom-control-label" for="a_cartera">A cartera</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="px-4 pt-2">
                                    <h5 class="mb-0">Observaciones</h5>
                                </div>
                                <div class="card-body">
                                    <input type="hidden" name="observaciones" id="observaciones_hidden">
                                    <textarea id="observaciones" cols="30" rows="10">{{ $formaPago->observaciones }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-12 text-center">
                            <button class="btn btn-primary btn-lg" id="actualizarFormaPago" type="submit">Editar
                                forma de pago</button>
                        </div>
                    </div>
                </form>


            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
        <div class="card">
            <div class="card-body">

                <p><strong>Vencimiento/s</strong></p>

                <div class="registrarVencimiento form-row">
                    <div class="d-flex">
                        <span class="input-group-append ml-3" style="height: 28px;">
                            <button class="btn btn-sm btn-gradient-primary asignarVencimiento"
                                type="button">Agregar</button>
                        </span>
                    </div>
                </div>
                <div class="col-12 mt-4 mb-5 table-responsive">
                    <table id="datatableVencimientos" class="table table-xs table-bordered mb-0 font-12">
                        <thead>
                            <tr>
                                <th>Porcentaje (%)</th>
                                <th>Días</th>
                                <th class="col-1">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="vencimientos.length==0">
                                <td colspan="20" class="text-center">No hay vencimientos</td>
                            </tr>
                            <template v-else>
                                <tr v-for="vencimiento,index in vencimientos" class="text-right">
                                    <td>
                                        <input type="number" step="0.01" @blur="changeArrayItem(vencimiento, index)"
                                            v-model="vencimiento.porcentaje" style="height: 22.5px;width: 100%;"
                                            class="form-control form-control-sm">
                                    </td>
                                    <td>
                                        <input type="number" step="1" @blur="changeArrayItem(vencimiento, index)"
                                            v-model="vencimiento.dias" style="height: 22.5px;width: 100%;"
                                            class="form-control form-control-sm">
                                    </td>
                                    <td class="text-center">
                                        <i class="fa fa-save text-success mr-2"></i>
                                        <i class="fa fa-trash text-danger" @click="eliminar(vencimiento, index)"></i>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                    <div>
                        <p>El porcentaje de los vencimientos debe sumar 100%.<br />
                            <strong><span class="informacionVencimientos"></span></strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
        <!--end row-->
    </div><!-- container -->
@endsection
@section('add-scripts')
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

            $("#editarFormaPago").submit(function(e) {
                e.preventDefault();
                $('#editarFormaPago').addClass('was-validated');
                if ($('#editarFormaPago')[0].checkValidity() === false) {
                    event.stopPropagation();
                } else {
                    $("#observaciones_hidden").val(tinymce.get('observaciones').getContent());
                    $.ajax({
                        type: "post",
                        url: "/formas_pago",
                        data: new FormData($('#editarFormaPago')[0]),
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend: function() {
                            $("#actualizarFormaPago").html(
                                "<i class='fa fa-spinner fa-pulse'></i><span class='sr-only'> Actualizando...</span>Actualizando..."
                            );
                            $("#actualizarFormaPago").attr("disabled", true);
                        },
                        dataType: "json",
                        success: function(data) {
                            $("#actualizarFormaPago").html("Actualizado");
                            $("#actualizarFormaPago").removeAttr("disabled");
                            if (data.status == "success") {
                                $('#editarFormaPago').removeClass('was-validated');
                                location.href = "/formas_pago"
                            } else if (data.status == "error") {
                                $('#editarFormaPago').removeClass('was-validated');
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

        });

        var vue_app = new Vue({
            el: "#formas_pago_app",
            data: {
                formaPago: {{ $formaPago->id }},
                vencimientos: @json($vencimientos),
            },
            methods: {
                changeArrayItem: function(item, index) {
                    axios.put("/formas_pago/vencimiento", {
                            id: item.id,
                            porcentaje: item.porcentaje,
                            dias: item.dias,
                            forma_pago_id: vue_app.formaPago
                        })
                        .then(response => {
                            var data = response.data;
                            vue_app.vencimientos = data.vencimientos;
                            comprobar_porcentaje(vue_app.vencimientos);
                        })
                },
                eliminar: function(item, index) {
                    Swal.fire({
                        title: "¿Está seguro de eliminar este vencimiento?",
                        text: "¡Si no lo está puede cancelar la acción!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Si, Eliminar!'
                    }).then((result) => {
                        if (result.value) {
                            axios.delete("/formas_pago/vencimiento/" + item.id)
                                .then(response => {
                                    if (response.data.status == "success") {
                                        vue_app.vencimientos.splice(index, 1);
                                    }
                                })
                        }
                    })
                }
            }
        });
        comprobar_porcentaje(vue_app.vencimientos);
        $(document).on("click", ".asignarVencimiento", function() {
            formData = new FormData();
            formData.append("porcentaje", 0);
            formData.append("dias", 0);
            formData.append("forma_pago_id", $("#forma_pago_id").val());
            vue_app.vencimientos.push({
                id: "",
                porcentaje: 0,
                dias: 0,
                forma_pago_id: $("#forma_pago_id").val()
            });
        });

        function comprobar_porcentaje(vencimientos) {
            let total = 0;
            vencimientos.forEach(vencimiento => {
                total += parseInt(vencimiento.porcentaje);
            });
            $(".informacionVencimientos").text("Lleva " + total + "/100");
        }
    </script>
@endsection
