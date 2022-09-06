<!-- Top Bar Start -->
<div class="topbar d-print-none" id="topbar">
    <!-- Navbar -->
    <nav class="navbar-custom">
        <ul class="list-unstyled topbar-nav float-right mb-0">
            <li class="hidden-sm">
                <a class="nav-link dropdown-toggle waves-effect waves-light" data-toggle="dropdown"
                    href="javascript: void(0);" role="button" aria-haspopup="false" aria-expanded="false" v-cloak
                    v-if="empresas.empresas.length != undefined && empresas.empresas.length > 0 && empresas.last_empresa_id != 0 && empresas.last_empresa_id != null && empresas.last_empresa_id != undefined"
                    v-for="(item, index) in empresas.empresas">
                    <template v-if="item.id == empresas.last_empresa_id">
                        <img :src="'https://ui-avatars.com/api/?background=random&bold=true&rounded=true&name='+item.nombre"
                            class="ml-2" height="20" alt="" /> <i class="mdi mdi-chevron-down"></i>
                        <span> @{{ item.nombre }} </span>
                    </template>
                </a>
                <div class="dropdown-menu dropdown-menu-right" v-cloak
                    v-if="empresas.empresas.length != undefined && empresas.empresas.length > 1">
                    <template v-cloak v-if="empresas.empresas.length != undefined && empresas.empresas.length > 1"
                        v-for="(empresa, index) in empresas.empresas">
                        <a class="dropdown-item" v-on:click="cambiarEmpresa(empresa.id)" href="javascript: void(0);"
                            v-if="empresa.id != empresas.last_empresa_id">
                            <img :src="'https://ui-avatars.com/api/?background=random&bold=true&rounded=true&name='+empresa.nombre"
                                alt="" class="ml-2 float-left" width="20" height="20" />
                            <span> @{{ empresa.nombre }} </span>
                        </a>
                    </template>
                </div>
            </li>
            <li class="dropdown">
                <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#"
                    role="button" aria-haspopup="false" aria-expanded="false">
                    <img src="https://ui-avatars.com/api/?background=random&bold=true&rounded=true&name={{ ucfirst(auth()->user()->nombre) }}"
                        alt="profile-user" class="rounded-circle" />
                    <span class="ml-1 nav-user-name hidden-sm">{{ ucwords(auth()->user()->nombre) }} <i
                            class="mdi mdi-chevron-down"></i> </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    @if (auth()->user()->existPermission(10151))
                        <a class="dropdown-item" href=""><i class="dripicons-user text-muted mr-2"></i> Perfil</a>
                    @endif
                    @if (auth()->user()->existPermission(10201))
                        <a class="dropdown-item" href="/configuracion"><i class="dripicons-gear text-muted mr-2"></i>
                            Configuraciones</a>
                    @endif

                    <a class="dropdown-item" href="{{ route('logout') }}"><i
                            class="dripicons-exit text-muted mr-2"></i> Cerrar sesión</a>
                </div>
            </li>
        </ul>
        <!--end topbar-nav-->

        <ul class="list-unstyled topbar-nav mb-0">
            <li>
                <a href="../analytics/analytics-index.html">
                    <span class="responsive-logo">
                        <img src="{{ asset('images/logoXS.png') }}" alt="logo-small" class="logo-sm align-self-center"
                            height="34">
                    </span>
                </a>
            </li>
            <li>
                <button class="button-menu-mobile nav-link">
                    <i data-feather="menu" class="align-self-center"></i>
                </button>
            </li>
            <li class="dropdown" hidden>
                <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#"
                    role="button" aria-haspopup="false" aria-expanded="false">
                    <span class="ml-1 p-2 bg-soft-classic nav-user-name hidden-sm rounded">System <i
                            class="mdi mdi-chevron-down"></i> </span>
                </a>
                <div class="dropdown-menu dropdown-xl dropdown-menu-left p-0">
                    <div class="row no-gutters">
                        <div class="col-12 col-lg-6">
                            <div class="text-center system-text">
                                <h4 class="text-white">The Poworfull Dashboard</h4>
                                <p class="text-white">See all the pages Metrica.</p>
                                <a href="https://mannatthemes.com/metrica/" class="btn btn-sm btn-pink mt-2">See
                                    Dashboard</a>
                            </div>
                            <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="{{ asset('images/dashboard/dash-1.png') }}"
                                            class="d-block img-fluid" alt="...">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="{{ asset('images/dashboard/dash-4.png') }}"
                                            class="d-block img-fluid" alt="...">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="{{ asset('images/dashboard/dash-2.png') }}"
                                            class="d-block img-fluid" alt="...">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="{{ asset('images/dashboard/dash-3.png') }}"
                                            class="d-block img-fluid" alt="...">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-12 col-lg-6">
                            <div class="divider-custom mb-0">
                                <div class="divider-text bg-light">All Dashboard</div>
                            </div>
                            <div class="p-4">
                                <div class="row">
                                    <div class="col-6">
                                        <a class="dropdown-item mb-2" href="../vertical-2/analytics-index.html">
                                            Analytics</a>
                                        <a class="dropdown-item mb-2" href="../vertical-2/crypto-index.html">
                                            Crypto</a>
                                        <a class="dropdown-item mb-2" href="../vertical-2/crm-index.html"> CRM</a>
                                        <a class="dropdown-item" href="../vertical-2/projects-index.html">
                                            Project</a>
                                    </div>
                                    <div class="col-6">
                                        <a class="dropdown-item mb-2" href="../vertical-2/ecommerce-index.html">
                                            Ecommerce</a>
                                        <a class="dropdown-item mb-2" href="../vertical-2/helpdesk-index.html">
                                            Helpdesk</a>
                                        <a class="dropdown-item" href="../vertical-2/hospital-index.html">
                                            Hospital</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div>
            </li>
            <li class="hide-phone app-search">
                {{-- <input type="text" id="buscar_miembro" placeholder="Buscar miembro..." autocomplete="off" class="form-control">
              <a href="javascript:void(0)" onClick="buscar_miembro_funcion()" ><i class="fas fa-search"></i></a> --}}
            </li>
        </ul>
    </nav>
    <!-- end navbar-->
</div>
<!-- Top Bar End -->
