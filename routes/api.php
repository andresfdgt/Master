<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/usuarios/empresas', [UsuarioController::class, 'empresas'])->name('empresas');
Route::put('/usuarios/empresas/{id}', [UsuarioController::class, 'establecerEmpresa'])->name('establecer.empresas');

// Route::group(['middleware' => 'auth:sanctum'], function () {
//    Route::group(['middleware' => 'BaseDatosPrivada'], function () {
//       Route::get('/miembros', [MiembrosController::class, 'lista']);
//       Route::get('/miembros/{id}', [MiembrosController::class, 'detalle']);

//       Route::get('/configuraciones/municipios/{id}', [ConfiguracionesController::class, 'municipios']);
//       Route::get('/configuraciones/jerarquias', [ConfiguracionesController::class, 'jerarquias']);
//       Route::post('/configuraciones/jerarquias', [ConfiguracionesController::class, 'jerarquia_store']);
//       Route::put('/configuraciones/jerarquias/{id}', [ConfiguracionesController::class, 'jerarquia_update']);
//       Route::delete('/configuraciones/jerarquias/{id}', [ConfiguracionesController::class, 'jerarquia_delete']);
//       Route::get('/configuraciones/tipo_ministerios', [ConfiguracionesController::class, 'tipo_ministerios']);
//       Route::post('/configuraciones/tipo_ministerios', [ConfiguracionesController::class, 'tipo_ministerio_store']);
//       Route::put('/configuraciones/tipo_ministerios', [ConfiguracionesController::class, 'tipo_ministerio_update']);
//       Route::delete('/configuraciones/tipo_ministerios/{id}', [ConfiguracionesController::class, 'tipo_ministerio_delete']);
//       Route::get('/configuraciones/departamentos', [ConfiguracionesController::class, 'departamentos']);
//       Route::get('/configuraciones/iglesia', [ConfiguracionesController::class, 'iglesia']);
//       Route::put('/configuraciones/iglesia', [ConfiguracionesController::class, 'iglesia_update']);

//       Route::get('/estudios', [EstudiosController::class, 'lista']);
//       Route::post('/estudios', [EstudiosController::class, 'store']);
//       Route::put('/estudios/{id}', [EstudiosController::class, 'update']);
//       Route::delete('/estudios/{id}', [EstudiosController::class, 'delete']);

//       Route::get('/ministerios', [MinisteriosController::class, 'lista']);
//       Route::post('/ministerios', [MinisteriosController::class, 'store']);
//       Route::put('/ministerios/{id}', [MinisteriosController::class, 'update']);
//       Route::delete('/ministerios/{id}', [MinisteriosController::class, 'delete']);

//       Route::get('/celulas', [CelulasController::class, 'lista']);
//       Route::post('/celulas', [CelulasController::class, 'store']);
//       Route::put('/celulas/{id}', [CelulasController::class, 'update']);
//       Route::delete('/celulas/{id}', [CelulasController::class, 'delete']);

//       Route::get('/agendas', [AgendasController::class, 'lista']);
//       Route::post('/agendas', [AgendasController::class, 'store']);
//       Route::put('/agendas/{id}', [AgendasController::class, 'update']);
//       Route::delete('/agendas/{id}', [AgendasController::class, 'delete']);

//       Route::get('/conversiones', [ConversionesController::class, 'index'])->middleware('can:conversiones')->name('conversiones');
//       Route::post('/conversiones', [ConversionesController::class, 'store'])->middleware('can:crear_conversion')->name('conversiones.store');
//       Route::get('/conversiones/buscar', [ConversionesController::class, 'buscar'])->name('conversiones.buscar');
//       Route::get('/conversiones/{id}', [ConversionesController::class, 'show'])->name('conversiones.show');
//       Route::put('/conversiones', [ConversionesController::class, 'update'])->middleware('can:actualizar_conversion')->name('conversiones.update');
//       Route::delete('/conversiones/{id}', [ConversionesController::class, 'delete'])->middleware('can:eliminar_conversion')->name('conversiones.delete');
//    });
// });
// Route::post('/auth', [LoginController::class, 'authenticate']);
