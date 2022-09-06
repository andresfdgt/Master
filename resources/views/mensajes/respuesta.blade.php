<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <!-- App favicon -->
    <link rel="icon" href="{{ asset('images/logoXS.png') }} "  id="light-scheme-icon" />
    {{-- <link rel="icon" href="{{ asset('images/icon_black.png') }} " media="prefers-color-scheme:no-preference)" />
    <link rel="icon" href="{{ asset('images/icon_white.png') }} " id="dark-scheme-icon" /> --}}

    <link rel="icon" href="icon.png" type="image/png" sizes="16x16" />
    <title>Iglenube - Administra tu iglesia</title>
    <meta name="description" content="Administra eficazmente la información de tu iglesia con Iglenube. Mantén organizada la información de tu iglesia desde cualquier lugar y en cualquier dispositivo."/>
    <meta name="keywords" content="Iglenube, Adminstración, Organiza, Información, Dispositivos"/>

    <!-- App css -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/jquery-ui.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/metisMenu.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/app.min.css') }}" rel="stylesheet" type="text/css" />
</head>
<body class="account-body accountbg">
    <div class="container">
        <div class="row vh-100">
            <div class="col-12 align-self-center">
                <div class="card auth-card shadow-lg mt-5">
            <div class="card-body ">
                <header id='main-header' style='margin-top:20px'>
                    <div class='row'>
                        <div class='col-lg-12 franja'>
                            <img class='center-block'
                                src='{{ asset('images/iglenube_vector.png') }}'
                                style=''>
                        </div>
                    </div>
                </header>
                <div class=''>
                    <div class='row' style='margin-top:20px'>
                        <div class='col-lg-8'>
                            <h4 style='text-align:left'> Respuesta de la Transacción </h4>
                            <hr>
                        </div>
                        <div class='col-lg-8'>
                            <div class='table-responsive'>
                                <table class='table table-bordered'>
                                    <tbody>
                                        <tr>
                                            <td>Referencia </td>
                                            <td id='referencia'>{{$res->x_id_invoice}}</td>
                                        </tr>
                                        <tr>
                                            <td class='bold'> Fecha </td>
                                            <td id='fecha'> {{ $res->x_transaction_date }} </td>
                                        </tr>
                                        <tr>
                                            <td> Respuesta </td>
                                            <td id='respuesta'>
                                                {{ $res->x_response }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td> Motivo </td>
                                            <td id='motivo'>{{ $res->x_response_reason_text }}</td>
                                        </tr>
                                        <tr>
                                            <td class='bold'> Banco </td>
                                            <td> {{ $res->x_bank_name }} </td>
                                        </tr>
                                        <tr>
                                            <td class='bold'> Recibo </td>
                                            <td id='recibo'>{{ $res->x_transaction_id }} </td>
                                        </tr>
                                        <tr>
                                            <td class='bold'> Total </td>
                                            <td>{{ $res->x_amount }} {{ $res->x_currency_code }} </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="row">
                                    <a href="{{route('mensajes.compras.solicitud')}}" class="btn btn-primary">Volver al dashboard</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <footer>
                    <div class='row'>
                        <div class='container'>
                            <div class='col-lg-8 col-lg-offset-2'>
                                <img src='https://369969691f476073508a-60bf0867add971908d4f26a64519c2aa.ssl.cf5.rackcdn.com/btns/epayco/pagos_procesados_por_epayco_260px.png'
                                    style='margin-top:10px; float:left'>
                                <img src='https://369969691f476073508a-60bf0867add971908d4f26a64519c2aa.ssl.cf5.rackcdn.com/btns/epayco/credibancologo.png'
                                    height='40px' style='margin-top:10px; float:right'>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
            </div>
        </div>
        

    </div>
</body>
</html>
