<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmpresasController;
use App\Http\Controllers\Auth\ForgotController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\Invitado\RegistrosController;
use App\Http\Controllers\MantenimientoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AgenciaTransporteController;
use App\Http\Controllers\IvaController;
use App\Http\Controllers\NumeracionController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\TipoPorteController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\TarifaController;
use App\Http\Controllers\FormasPagoController;
use App\Http\Controllers\LocalizacionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/auth');
});
Route::get('/auth', [LoginController::class, 'login'])->name('login')->middleware('guest');
Route::get('/registro', [RegistrosController::class, 'registro'])->name('registro');
Route::post('/registro', [RegistrosController::class, 'registrar'])->name('registrar');

Route::post('/auth', [LoginController::class, 'authenticate'])->name('auth');
Route::get('/logout', [LoginController::class, 'logout'])->middleware(['auth'])->name('logout');

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::prefix('empresas')->group(function () {
        Route::get('/', [EmpresasController::class, 'index'])->name('empresas.index')->middleware("ExistPermission:10051");
        Route::get('/roles/{id}', [EmpresasController::class, 'roles'])->name('empresas.roles');
        Route::get('/usuarios/{id}', [EmpresasController::class, 'usuarios'])->name('empresas.usuarios');
        Route::get('/{id}', [EmpresasController::class, 'show'])->name('empresas.show');
        Route::post('/', [EmpresasController::class, 'store'])->name('empresas.store')->middleware("ExistPermission:10052");
        Route::put('/estado', [EmpresasController::class, 'estado'])->name('empresas.estado')->middleware("ExistPermission:10055");
        Route::put('/', [EmpresasController::class, 'update'])->name('empresas.update')->middleware("ExistPermission:10053");
        Route::delete('/{id}', [EmpresasController::class, 'delete'])->name('empresas.delete')->middleware("ExistPermission:10054");
    });

    Route::group(['middleware' => 'BaseDatosPrivada'], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil');
        Route::put('/perfil', [PerfilController::class, 'update']);

        Route::prefix('configuracion')->group(function () {

            Route::get('/roles', [PerfilController::class, 'roles'])->name('configuracion.roles')->middleware("ExistPermission:10101");
            Route::get('/roles/crear', [PerfilController::class, 'crearRol'])->name('configuracion.crear_rol')->middleware("ExistPermission:10102");
            Route::get('/roles/editar/{id}', [PerfilController::class, 'editarRol'])->name('configuracion.editar_rol')->middleware("ExistPermission:10103");
            Route::post('/roles', [PerfilController::class, 'storeRol'])->name('configuracion.store_rol');
            Route::put('/roles', [PerfilController::class, 'updateRol'])->name('configuracion.update_rol');
            Route::get('/', [PerfilController::class, 'configuracion'])->name('configuracion')->middleware("ExistPermission:10201");
            Route::put('/', [PerfilController::class, 'configuracionUpdate']);
        });

        Route::prefix('usuarios')->group(function () {
            Route::get('/', [UsuarioController::class, 'index'])->name('usuarios')->middleware("ExistPermission:10000");
            Route::get('/tipo_empresa_permisos/{id}', [UsuarioController::class, 'tipoEmpresaPermisos'])->name('usuarios.tipo_empresa_permisos');
            Route::get('/empresas', [UsuarioController::class, 'empresas'])->name('usuarios.empresas');
            Route::get('/crear', [UsuarioController::class, 'crear'])->name('usuarios.crear')->middleware("ExistPermission:10001");
            Route::get('/exist/{id}', [UsuarioController::class, 'exist'])->name('usuarios.exist');
            Route::get('/editar/{id}', [UsuarioController::class, 'editar'])->name('usuarios.editar')->middleware("ExistPermission:20");
            Route::post('/', [UsuarioController::class, 'store'])->name('usuarios.store');
            Route::get('/{id}', [UsuarioController::class, 'show'])->name('usuarios.show');
            Route::put('/empresas/{id}', [UsuarioController::class, 'establecerEmpresa'])->name('usuarios.establecer.empresas');
            Route::put('/', [UsuarioController::class, 'update'])->name('usuarios.update');
            Route::put('/estado', [UsuarioController::class, 'estado'])->name('usuarios.estado');
            Route::delete('/{id}', [UsuarioController::class, 'delete'])->name('usuarios.delete')->middleware("ExistPermission:10003");
        });

        Route::prefix('agencias_transporte')->group(function () {
            Route::get('/', [AgenciaTransporteController::class, 'index'])->name('agencias_transporte')->middleware("ExistPermission:10251");
            Route::get('/agencias_transporte', [AgenciaTransporteController::class, 'agenciasTransporte'])->name('agencias_transporte.agencias_transporte')->middleware("ExistPermission:10251");
            Route::get('/crear', [AgenciaTransporteController::class, 'crear'])->name('agencias_transporte.crear')->middleware("ExistPermission:10252");
            Route::get('/editar/{id}', [AgenciaTransporteController::class, 'editar'])->name('agencias_transporte.editar')->middleware("ExistPermission:10252");
            Route::get('/favorito/{id}', [AgenciaTransporteController::class, 'updateFavorito'])->name('agencias_transporte.favorito')->middleware("ExistPermission:10252");
            Route::post('/', [AgenciaTransporteController::class, 'store'])->name('agencias_transporte.store');
            Route::put('/', [AgenciaTransporteController::class, 'update'])->name('agencias_transporte.update');
            Route::delete('/{id}', [AgenciaTransporteController::class, 'delete'])->name('agencias_transporte.delete')->middleware("ExistPermission:10252");
        });

        Route::prefix('iva')->group(function () {
            Route::get('/articulos', [IvaController::class, 'index_articulos'])->name('iva.articulos')->middleware("ExistPermission:10251");
            Route::get('/articulos/iva_articulos', [IvaController::class, 'ivaArticulos'])->name('iva.articulos.iva_articulos')->middleware("ExistPermission:10251");
            Route::get('/articulos/crear', [IvaController::class, 'crear'])->name('iva.articulos.crear')->middleware("ExistPermission:10252");
            Route::get('/articulos/editar/{id}', [IvaController::class, 'editar'])->name('iva.articulos.editar')->middleware("ExistPermission:10252");
            Route::get('/articulos/favorito/{id}', [IvaController::class, 'updateFavorito'])->name('iva.articulos.favorito')->middleware("ExistPermission:10252");
            Route::post('/articulos', [IvaController::class, 'store'])->name('iva.articulos.store');
            Route::put('/articulos', [IvaController::class, 'update'])->name('iva.articulos.update');
            Route::delete('/articulos/{id}', [IvaController::class, 'delete'])->name('iva.articulos.delete')->middleware("ExistPermission:10252");

            Route::get('/clientes', [IvaController::class, 'index_clientes'])->name('iva.clientes')->middleware("ExistPermission:10251");
            Route::get('/clientes/iva_clientes', [IvaController::class, 'ivaClientes'])->name('iva.clientes.iva_clientes')->middleware("ExistPermission:10251");
            Route::get('/clientes/crear', [IvaController::class, 'crearIvaCliente'])->name('iva.clientes.crear')->middleware("ExistPermission:10252");
            Route::get('/clientes/editar/{id}', [IvaController::class, 'editarIvaCliente'])->name('iva.clientes.editar')->middleware("ExistPermission:10252");
            Route::get('/clientes/favorito/{id}', [IvaController::class, 'updateFavoritoIvaCliente'])->name('iva.clientes.favorito')->middleware("ExistPermission:10252");
            Route::post('/clientes', [IvaController::class, 'storeIvaCliente'])->name('iva.clientes.store');
            Route::put('/clientes', [IvaController::class, 'updateIvaCliente'])->name('iva.clientes.update');
            Route::delete('/clientes/{id}', [IvaController::class, 'deleteIvaCliente'])->name('iva.clientes.delete')->middleware("ExistPermission:10252");
        });

        Route::prefix('numeraciones')->group(function () {
            Route::get('/', [NumeracionController::class, 'index'])->name('numeraciones')->middleware("ExistPermission:10251");
            Route::get('/numeraciones', [NumeracionController::class, 'numeraciones'])->name('numeraciones.numeraciones')->middleware("ExistPermission:10251");
            Route::get('/crear', [NumeracionController::class, 'crear'])->name('numeraciones.crear')->middleware("ExistPermission:10252");
            Route::get('/editar/{id}', [NumeracionController::class, 'editar'])->name('numeraciones.editar')->middleware("ExistPermission:10252");
            Route::get('/favorito/{id}', [NumeracionController::class, 'updateFavorito'])->name('numeraciones.favorito')->middleware("ExistPermission:10252");
            Route::post('/', [NumeracionController::class, 'store'])->name('numeraciones.store');
            Route::put('/', [NumeracionController::class, 'update'])->name('numeraciones.update');
            Route::delete('/{id}', [NumeracionController::class, 'delete'])->name('numeraciones.delete')->middleware("ExistPermission:10252");
        });

        Route::prefix('categorias')->group(function () {
            Route::get('/', [CategoriaController::class, 'index'])->name('categorias')->middleware("ExistPermission:10251");
            Route::get('/categorias', [CategoriaController::class, 'categorias'])->name('categorias.categorias')->middleware("ExistPermission:10251");
            Route::get('/crear', [CategoriaController::class, 'crear'])->name('categorias.crear')->middleware("ExistPermission:10252");
            Route::get('/editar/{id}', [CategoriaController::class, 'editar'])->name('categorias.editar')->middleware("ExistPermission:10252");
            Route::post('/', [CategoriaController::class, 'store'])->name('categorias.store');
            Route::put('/', [CategoriaController::class, 'update'])->name('categorias.update');
            Route::delete('/{id}', [CategoriaController::class, 'delete'])->name('categorias.delete')->middleware("ExistPermission:10252");
        });

        Route::prefix('tipo_portes')->group(function () {
            Route::get('/', [TipoPorteController::class, 'index'])->name('tipo_portes')->middleware("ExistPermission:10251");
            Route::get('/tipo_portes', [TipoPorteController::class, 'tipoPortes'])->name('tipo_portes.tipo_portes')->middleware("ExistPermission:10251");
            Route::get('/crear', [TipoPorteController::class, 'crear'])->name('tipo_portes.crear')->middleware("ExistPermission:10252");
            Route::get('/editar/{id}', [TipoPorteController::class, 'editar'])->name('tipo_portes.editar')->middleware("ExistPermission:10252");
            Route::get('/favorito/{id}', [TipoPorteController::class, 'updateFavorito'])->name('tipo_portes.favorito')->middleware("ExistPermission:10252");
            Route::post('/', [TipoPorteController::class, 'store'])->name('tipo_portes.store');
            Route::put('/', [TipoPorteController::class, 'update'])->name('tipo_portes.update');
            Route::delete('/{id}', [TipoPorteController::class, 'delete'])->name('tipo_portes.delete')->middleware("ExistPermission:10252");
        });

        Route::prefix('marcas')->group(function () {
            Route::get('/', [MarcaController::class, 'index'])->name('marcas')->middleware("ExistPermission:10251");
            Route::get('/marcas', [MarcaController::class, 'marcas'])->name('marcas.marcas')->middleware("ExistPermission:10251");
            Route::get('/crear', [MarcaController::class, 'crear'])->name('marcas.crear')->middleware("ExistPermission:10252");
            Route::post('/', [MarcaController::class, 'store'])->name('marcas.store');
            Route::get('/editar/{id}', [MarcaController::class, 'editar'])->name('marcas.editar')->middleware("ExistPermission:10252");
            Route::put('/', [MarcaController::class, 'update'])->name('marcas.update');
            Route::get('/favorito/{id}', [MarcaController::class, 'updateFavorito'])->name('marcas.favorito')->middleware("ExistPermission:10252");
            Route::delete('/{id}', [MarcaController::class, 'delete'])->name('marcas.delete')->middleware("ExistPermission:10252");
        });

        Route::prefix('tarifas')->group(function () {
            Route::get('/', [TarifaController::class, 'index'])->name('tarifas')->middleware("ExistPermission:10251");
            Route::get('/tarifas', [TarifaController::class, 'tarifas'])->name('tarifas.tarifas')->middleware("ExistPermission:10251");
            Route::get('/crear', [TarifaController::class, 'crear'])->name('tarifas.crear')->middleware("ExistPermission:10252");
            Route::post('/', [TarifaController::class, 'store'])->name('tarifas.store');
            Route::get('/editar/{id}', [TarifaController::class, 'editar'])->name('tarifas.editar')->middleware("ExistPermission:10252");
            Route::put('/', [TarifaController::class, 'update'])->name('tarifas.update');
            Route::delete('/{id}', [TarifaController::class, 'delete'])->name('tarifas.delete')->middleware("ExistPermission:10252");
        });

        Route::prefix('formas_pago')->group(function () {
            Route::get('/', [FormasPagoController::class, 'index'])->name('formas_pago')->middleware("ExistPermission:10251");
            Route::get('/formas_pago', [FormasPagoController::class, 'formasPago'])->name('formas_pago.formas_pago')->middleware("ExistPermission:10251");
            Route::get('/crear', [FormasPagoController::class, 'crear'])->name('formas_pago.crear')->middleware("ExistPermission:10252");
            Route::get('/editar/{id}', [FormasPagoController::class, 'editar'])->name('formas_pago.editar')->middleware("ExistPermission:10252");
            Route::get('/favorito/{id}', [FormasPagoController::class, 'updateFavorito'])->name('formas_pago.favorito')->middleware("ExistPermission:10252");
            Route::get('/remesable/{id}/{remesable}', [FormasPagoController::class, 'updateRemesable'])->name('formas_pago.remesable')->middleware("ExistPermission:10252");
            Route::get('/a_cartera/{id}/{a_cartera}', [FormasPagoController::class, 'updateACartera'])->name('formas_pago.a_cartera')->middleware("ExistPermission:10252");
            Route::post('/', [FormasPagoController::class, 'store'])->name('formas_pago.store');
            Route::put('/', [FormasPagoController::class, 'update'])->name('formas_pago.update');
            Route::put('/vencimiento', [FormasPagoController::class, 'updateVencimiento'])->name('formas_pago.updateVencimiento')->middleware("ExistPermission:10251");
            Route::delete('/{id}', [FormasPagoController::class, 'delete'])->name('formas_pago.delete')->middleware("ExistPermission:10252");
            Route::delete('/vencimiento/{id}', [FormasPagoController::class, 'deleteVencimiento'])->name('formas_pago.deleteVencimiento')->middleware("ExistPermission:10251");
        });
    });
});

Route::group(['middleware' => ['guest']], function () {

    Route::get('/auth/forgot-password', [ForgotController::class, 'index'])->name('password.request');
    Route::post('/auth/forgot-password', [ForgotController::class, 'resetLink'])->name('password.email');

    Route::get('/reset-password/{token}', function ($token) {
        return view('auth.reset-password', ['token' => $token]);
    })->name('password.reset');

    Route::post('/reset-password', [ForgotController::class, 'reset'])->name('password.update');
});

Route::get('/mantenimiento_alter', [MantenimientoController::class, 'index']);

Route::group(['middleware' => ['cors']], function () {
    Route::get('/getDatosLocalizacion/{codigoPostal}', [LocalizacionController::class, 'provinciaLocalidad'])->name('getDatosLocalizacion');
});
