<!-- Left Sidenav -->
<div class="left-sidenav">
    <div class="topbar-left">
        <a href="/dashboard/" class="logo">
            <span>
                {{-- <img src="{{ asset('images/logoLG.png') }}" alt="logo-large" class="logo-lg logo-light"> --}}
                <img src="{{ asset('images/logo.png') }}" width="70" alt="Logo Iglenube" class="auth-logo">
            </span>
        </a>
    </div>
    <div class="leftbar-profile p-3 w-100">
        <div class="media position-relative">
            <div class="leftbar-user online">
                <img src="https://ui-avatars.com/api/?background=random&bold=true&rounded=true&name={{ ucfirst(auth()->user()->nombre) }}"
                    alt="" class="thumb-md rounded-circle">
            </div>
            <div class="media-body align-self-center text-truncate ml-3">
                @php
                    $data = explode(' ', ucwords(auth()->user()->nombre));
                    echo '<h5 class="mt-0 mb-1 font-weight-semibold">' . $data[0] . ' ' . ($data[1] ?? '') . '</h5>';
                @endphp
            </div>
        </div>
    </div>
    <ul class="metismenu left-sidenav-menu slimscroll">
        {{-- @if (auth()->user()->rol == 'master' ||
    auth()->user()->existPermission(22))
            <li class="leftbar-menu-item">
                <a href="{{ route('empresas') }}" class="menu-link">
                    <i data-feather="home" class="align-self-center vertical-menu-icon icon-dual-vertical"></i>
                    <span>Empresas</span>
                </a>
            </li>
        @endif --}}
        @if (Request::is('configuracion/*') || Request::is('configuracion') || Request::is('agencias_transporte/*') || Request::is('agencias_transporte') || Request::is('iva/*') || Request::is('iva') || Request::is('numeraciones/*') || Request::is('numeraciones') || Request::is('categorias/*') || Request::is('categorias') || Request::is('tipo_portes/*') || Request::is('tipo_portes') || Request::is('marcas') || Request::is('marcas/*') || Request::is('tarifas') || Request::is('tarifas/*') || Request::is('formas_pago') || Request::is('formas_pago/*'))
            <li class="leftbar-menu-item">
                <a href="{{ route('usuarios') }}" class="menu-link">
                    <i data-feather="home" class="align-self-center vertical-menu-icon icon-dual-vertical"></i>
                    <span>Inicio</span>
                </a>
            </li>
            <li class="leftbar-menu-item">
                <a href="{{ route('configuracion') }}" class="menu-link">
                    <i data-feather="settings" class="align-self-center vertical-menu-icon icon-dual-vertical"></i>
                    <span>Datos generales</span>
                </a>
            </li>
            <li class="leftbar-menu-item">
                <a href="{{ route('agencias_transporte') }}" class="menu-link">
                    <i data-feather="truck" class="align-self-center vertical-menu-icon icon-dual-vertical"></i>
                    <span>Agencias de transporte</span>
                </a>
            </li>
            <li class="leftbar-menu-item">
                <a href="javascript: void(0);" class="menu-link">
                    <i data-feather="dollar-sign" class="align-self-center vertical-menu-icon icon-dual-vertical"></i>
                    <span>IVA</span>
                    <span class="menu-arrow">
                        <i class="mdi mdi-chevron-right"></i>
                    </span>
                </a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li class="lnav-item">
                        <a href="{{ route('iva.articulos') }}" class="nav-link">
                            <i class="ti-control-record"></i>
                            <span>Artículos</span>
                        </a>
                    </li>
                    <li class="lnav-item">
                        <a href="{{ route('iva.clientes') }}" class="nav-link">
                            <i class="ti-control-record"></i>
                            <span>Clientes</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="leftbar-menu-item">
                <a href="{{ route('numeraciones') }}" class="menu-link">
                    <i data-feather="hash" class="align-self-center vertical-menu-icon icon-dual-vertical"></i>
                    <span>Numeraciones</span>
                </a>
            </li>
            <li class="leftbar-menu-item">
                <a href="javascript: void(0);" class="menu-link">
                    <i data-feather="list" class="align-self-center vertical-menu-icon icon-dual-vertical"></i>
                    <span>Categorías</span>
                </a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li class="lnav-item">
                        <a href="{{ route('categorias') }}" class="nav-link">
                            <i class="ti-control-record"></i>
                            <span>Categorías</span>
                        </a>
                    </li>
                    <li class="lnav-item">
                        <a href="{{ route('marcas') }}" class="nav-link">
                            <i class="ti-control-record"></i>
                            <span>Marcas</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="leftbar-menu-item">
                <a href="{{ route('tipo_portes') }}" class="menu-link">
                    <i data-feather="package" class="align-self-center vertical-menu-icon icon-dual-vertical"></i>
                    <span>Tipo de portes</span>
                </a>
            </li>
            <li class="leftbar-menu-item">
                <a href="{{ route('tarifas') }}" class="menu-link">
                    <i data-feather="percent" class="align-self-center vertical-menu-icon icon-dual-vertical"></i>
                    <span>Tarifas</span>
                </a>
            </li>
            <li class="leftbar-menu-item">
                <a href="{{ route('formas_pago') }}" class="menu-link">
                    <i data-feather="credit-card" class="align-self-center vertical-menu-icon icon-dual-vertical"></i>
                    <span>Formas de pago</span>
                </a>
            </li>
        @else
            @php
                $menu = auth()
                    ->user()
                    ->menu();
            @endphp
            @foreach ($menu as $item)
                @if ($item->url != '#')
                    @php
                        $target = $item->external ? 'target="_blank"' : '';
                    @endphp
                    <li class="leftbar-menu-item">
                        <a href="{{ $item->base . $item->url }}" {{ $target }} class="menu-link">
                            {!! base64_decode($item->icono) !!}
                            <span>{{ $item->nombre }}</span>
                        </a>
                    </li>
                @else
                    <li class="leftbar-menu-item">
                        <a href="javascript: void(0);" class="menu-link">
                            {!! base64_decode($item->icono) !!}
                            <span>{{ $item->nombre }}</span>
                            <span class="menu-arrow">
                                <i class="mdi mdi-chevron-right"></i>
                            </span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            @foreach ($item->hijos as $hijo)
                                @php
                                    $target_hijo = $hijo->external ? 'target="_blank"' : '';
                                @endphp
                                <li class="lnav-item">
                                    <a href="{{ $hijo->base . $hijo->url }}" {{ $target_hijo }} class="nav-link">
                                        <i class="ti-control-record"></i>
                                        <span>{{ $hijo->nombre }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endif
            @endforeach
        @endif
    </ul>
</div>
