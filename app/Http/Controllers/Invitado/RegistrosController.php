<?php

namespace App\Http\Controllers\Invitado;

use App\Http\Controllers\Controller;
use App\Mail\RegresarMailable;
use App\Models\Datos_padre;
use App\Models\Miembros;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;

class RegistrosController extends Controller
{
  public function registro()
  {
    return view('invitado.registro');
  }
  public function registrar(Request $request)
  {
    $validator =  Validator::make($request->all(), [
      'nombre' => 'required',
      'razon_social' => 'required',
      'cif_dni' => 'required',
      'pais' => 'required',
      'codigo_postal' => 'required',
      'localidad' => 'required',
      'provincia' => 'required',
      'direccion' => 'required',
      'telefono' => 'required',
      'telefono_2' => 'required',
      'email' => 'required|unique:clientes,email',
      'password' => 'required|min:5',
      'password_confirmation' => 'required_with:password|same:password|min:6'
    ]);
    if ($validator->fails()) {
      return response()->json([
        'status' => 'error',
        'title' => "Oops... Algo salió mal",
        'message' => $validator->errors()->first()
      ]);
    }
    DB::beginTransaction();
    try {
      $fecha_actual = Carbon::now()->format("Y-m-d H:i:s");
      $nombre = strtolower($request->nombre);
      $email = strtolower($request->email);
      $cliente_id = DB::table('clientes')
        ->insertGetId([
          "cif_dni" => $request->cif_dni,
          "nombre" => $nombre,
          "razon_social" => strtolower($request->razon_social),
          "pais" => strtolower($request->pais),
          "codigo_postal" => $request->codigo_postal,
          "localidad" => strtolower($request->localidad),
          "provincia" => strtolower($request->provincia),
          "direccion" =>strtolower($request->direccion),
          "telefono" => $request->telefono,
          "telefono_2" => $request->telefono_2,
          "email" => $email,
          "estado" => 1,
          "created_at" => $fecha_actual,
          "updated_at" => $fecha_actual
        ]);
      $usuario_id = DB::table('usuarios')
        ->insertGetId([
          "nombre" => $nombre,
          "email" => $email,
          "password" => Hash::make($request->password),
          "estado" => 1,
          "rol" => "master",
          "base_datos" => "",
          "last_empresa_id" => 0,
          "created_at" => $fecha_actual,
          "updated_at" => $fecha_actual
        ]);

      DB::table('clientes')->where("id",$cliente_id)
        ->update([
          "usuario_id" => $usuario_id,
        ]);

      DB::commit();
      // $user = User::where('email', $email)->first();
      // event(new Registered($user));
      // $correo = new RegresarMailable();
      // $correo->subject = "Registro iglenube";
      // $correo->head = "Hola, iglesia $request->nombre.";
      // $correo->body = "te has registrado con el plan Demo. Disfruta los días de prueba y mantén la información de tu iglesia al día con Iglenube..";
      // $correo->footer = "Iglenube, tu iglesia sincronizada al alcance de un clic.";
      // $correo->url = "https://dashboard.iglenube.com/auth/";
      // if ($request->tipo_registro == 2) {
      //   $correo->url = "https://org.iglenube.com/auth/";
      // }
      // Mail::to($email)->send($correo);
      return response()->json(array("status" => 'success', "title" => "Buen trabajo", "message" => "Cuenta creada correctamente"));
    } catch (\Exception $e) {
      DB::rollback();
      return response()->json(array("status" => 'error', "title" => "Oops... Algo salió mal", "message" => $e->getMessage()));
    }
  }
}
