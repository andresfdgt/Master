<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Helpers\CustomResponse;


class UsuarioController extends Controller
{
  public function index(Request $request)
  {
    $principal = Usuarios::first()->id;
    if (Auth::user()->rol == "master") {
      $cliente = Usuarios::clientes(Auth::id());
      $usuarios = Usuarios::join("usuarios_empresas as ue", "usuarios.id", "ue.usuario_id")->join("empresas as e", "ue.empresa_id", "e.id")->where("e.cliente_id", $cliente)->select("usuarios.*")->groupBy("usuarios.id")->get();
    } else {
      $empresas = DB::select("SELECT empresa_id FROM usuarios_empresas WHERE usuario_id =" . Auth::id());
      $empresas = array_column(json_decode(json_encode($empresas), true), "empresa_id");
      $usuarios = Usuarios::join("usuarios_empresas as ue", "usuarios.id", "ue.usuario_id")->whereIn("ue.empresa_id", $empresas)->groupBy("usuarios.id")->select("usuarios.*")->get();
    }
    return view('usuarios', compact('usuarios', 'principal'));
  }

  public function crear()
  {
    $empresas = DB::select("SELECT e.id, e.nombre FROM empresas as e, usuarios_empresas as ue WHERE e.id = ue.empresa_id AND ue.usuario_id =" . Auth::id());
    return view('crear_usuario', compact("empresas"));
  }
  public function store(Request $request)
  {
    if($request->userExist == 0) {
      $validator =  Validator::make($request->all(), [
        'nombre' => 'required',
        'correo' => 'required|unique:usuarios,email',
        'contraseña' => 'required'
      ]);
      if ($validator->fails()) {
        return response()->json([
          'status' => 'error',
          'title' => "Oops... Algo salió mal",
          'message' => $validator->errors()->first()
        ]);
      }
    }
    $fecha_actual = Carbon::now();
    DB::beginTransaction();
    try {
      if($request->userExist == 0){
        $password = Hash::make($request->contraseña);
        $id_usuario = DB::table('usuarios')
          ->insertGetId([
            "unique_id" =>Str::uuid(),
            "nombre" => $request->nombre,
            "email" => strtolower($request->correo),
            "email_verified_at" => $fecha_actual,
            "last_empresa_id" => 0,
            "estado" => 1,
            "rol" => 'otro',
            "password" => $password,
            "created_at" => $fecha_actual,
            "updated_at" => $fecha_actual
          ]);
        }else{
          $id_usuario = $request->userExist;
        }
      $empresas_roles = json_decode($request->empresas_roles);
      foreach ($empresas_roles as $empresa_rol) {
        # code...
        $permisos = [];
        $data_permisos = DB::table("roles_permisos")->where("role_id", $empresa_rol->id_rol)->select("permission_id")->get();
        foreach ($data_permisos as $permiso) {
          $permisos[] = [
            "permission_id" => $permiso->permission_id,
            "model_type" => "App\Models\User",
            "model_id" => $id_usuario,
            "empresa_id" => $empresa_rol->id_empresa
          ];
        }
        DB::table('model_has_permissions')
          ->insert($permisos);
        DB::table('usuarios_empresas')
          ->insert([
            "usuario_id" => $id_usuario,
            "empresa_id" => $empresa_rol->id_empresa,
            "rol_id" => $empresa_rol->id_rol,
          ]);
      }
      $base_datos = DB::select("SELECT base_datos FROM empresas WHERE id = {$empresas_roles[0]->id_empresa}")[0]->base_datos;
      DB::table("usuarios")->where("id", $id_usuario)
        ->update([
          "last_empresa_id" => $empresas_roles[0]->id_empresa,
          "base_datos" => $base_datos,
        ]);
      DB::commit();
      return response()->json(array("status" => 'success', "title" => "Buen trabajo", "message" => "Usuario creado exitosamente"));
    } catch (\Exception $e) {
      DB::rollback();
      return response()->json(array("status" => 'error', "title" => "Oops... Algo salió mal", "message" => $e->getMessage()));
    }
  }
  public function empresas(Request $request)
  {
    if($request->usuario_id){
      $last_bussine_id = DB::table("usuarios")->where("id", $request->usuario_id)->first()->last_empresa_id;
      $usuario_id =$request->usuario_id;

    }else{
      $usuario_id = Auth::id();
      $last_bussine_id = Auth::user()->last_empresa_id;
    }
    $empresas = DB::select("SELECT e.id, e.razon_social as nombre FROM empresas as e, usuarios_empresas as ue WHERE e.id = ue.empresa_id AND ue.usuario_id =" . $usuario_id);
    $data["empresas"] = $empresas;
    $data["last_empresa_id"] = $last_bussine_id;
    return  response()->json($data);
  }
  public function editar($id)
  {
    $empresas = DB::select("SELECT e.id, e.nombre FROM empresas as e, usuarios_empresas as ue WHERE e.id = ue.empresa_id AND ue.usuario_id =" . Auth::id());
    $usuario = DB::table('usuarios')->where('id', $id)->select('id', 'nombre', 'email')->first();
    $empresas_roles = DB::select("SELECT r.id as id_rol, r.name as rol, e.id as id_empresa, e.nombre as empresa FROM usuarios_empresas as ue, empresas as e, roles_app as r WHERE ue.empresa_id = e.id AND ue.rol_id = r.id AND ue.usuario_id = $id");
    $existeAdmin = DB::table('usuarios_empresas')->where('usuario_id', $id)->where("rol_id",0)->select('empresa_id')->get();
    if($existeAdmin){
      foreach ($existeAdmin as $key => $exist) {
        $empresas_roles[] = [
          "id_rol" => 0,
          "rol" => "Administrador",
          "id_empresa" => $exist->empresa_id,
          "empresa" => DB::table('empresas')->where('id', $exist->empresa_id)->select('nombre')->first()->nombre
        ];
      }
    }
    
    return view('editar_usuario', compact('usuario', 'empresas_roles', "empresas"));
  }
  public function update(Request $request)
  {
    $validator =  Validator::make($request->all(), [
      'nombre' => 'required',
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
      DB::table('usuarios')
        ->where('id', $request->id)
        ->update([
          "nombre" => $request->nombre,
          "updated_at" => Carbon::now()
        ]);
      DB::table("model_has_permissions")->where("model_id", $request->id)->delete();
      DB::table("usuarios_empresas")->where("usuario_id", $request->id)->delete();
      $empresas_roles = json_decode($request->empresas_roles);
      foreach ($empresas_roles as $empresa_rol) {
        # code...
        $permisos = [];
        $data_permisos = DB::table("roles_permisos")->where("role_id", $empresa_rol->id_rol)->select("permission_id")->get();
        foreach ($data_permisos as $permiso) {
          $permisos[] = [
            "permission_id" => $permiso->permission_id,
            "model_type" => "App\Models\User",
            "model_id" => $request->id,
            "empresa_id" => $empresa_rol->id_empresa
          ];
        }
        DB::table('model_has_permissions')
          ->insert($permisos);
        DB::table('usuarios_empresas')
          ->insert([
            "usuario_id" => $request->id,
            "empresa_id" => $empresa_rol->id_empresa,
            "rol_id" => $empresa_rol->id_rol,
          ]);
      }
      $base_datos = DB::select("SELECT base_datos FROM empresas WHERE id = {$empresas_roles[0]->id_empresa}")[0]->base_datos;
      DB::table("usuarios")->where("id", $request->id)
        ->update([
          "last_empresa_id" => $empresas_roles[0]->id_empresa,
          "base_datos" => $base_datos,
        ]);
      DB::commit();
      return response()->json(array("status" => 'success', "title" => "Buen trabajo", "message" => "Usuario actualizado exitosamente"));
    } catch (\Exception $e) {
      DB::rollback();
      return response()->json(array("status" => 'error', "title" => "Oops... Algo salió mal", "message" => $e->getMessage()));
    }
  }
  public function delete($id_usuario)
  {
    try {
      $usuario = Usuarios::findOrFail($id_usuario);
      $usuario->email = $usuario->email . "_delete" . $usuario->id;
      $usuario->delete();
      return response()->json(array("status" => 'success', "title" => "Buen trabajo", "message" => "Usuario eliminado correctamente"));
    } catch (ModelNotFoundException | \Exception $th) {
      return response()->json(array("status" => 'error', "title" => "Oops... Algo salió mal", "message" => $th->getMessage()));
    }
  }
  public function estado(Request $request)
  {
    try {
      $usuario = $request->usuario;
      $estado = $request->estado;
      Usuarios::where('id', $usuario)->update(['estado' => $estado]);
      return response()->json(array("status" => 'success', "title" => "Buen trabajo", "message" => "Estado del usuario actualizado correctamente"));
    } catch (ModelNotFoundException | \Exception $th) {
      return response()->json(array("status" => 'error', "title" => "Oops... Algo salió mal", "message" => "Hay un error vuelva a intentarlo"));
    }
  }

  public function tipoEmpresaPermisos($empresa_id)
  {
    $tipo_empresa_id = DB::select("SELECT tipo FROM empresas WHERE id = $empresa_id")[0]->tipo;
    $permisos_tipo_empresa = DB::select("SELECT id,nombre FROM tipo_empresas_permisos WHERE tipo_empresa_id = $tipo_empresa_id");
    return  response()->json($permisos_tipo_empresa);
  }

  public function establecerEmpresa(Request $request, $id)
  {
    if($request->usuario_id){
      $usuario_id =$request->usuario_id;

    }else{
      $usuario_id = Auth::id();
    }
    $empresas = DB::table("empresas")->where("id",$id)->first();
    DB::table("usuarios")->where("id",$usuario_id )->update([
      "last_empresa_id" => $id,
      "base_datos" => $empresas->base_datos
    ]);
    $configuracion = DB::table("configuracion as c")->join("paises as p","p.id","c.pais_id")->where("empresa_id", $id)->select("c.formato_fecha","p.utc","c.decimales")->first();
    $request->session()->put('formato_fecha', $configuracion->formato_fecha);
    $request->session()->put('utc', $configuracion->utc);
    $request->session()->put('decimales', $configuracion->decimales);
    return  response()->json(true);
  }

  

  public function exist($email)
  {
    $email = strtolower($email);
    $cliente_id = DB::table('empresas')->where('id', Auth::user()->last_empresa_id)->select('cliente_id')->first()->cliente_id;
    $empresas = DB::table('empresas')->where("cliente_id", $cliente_id)->select('id')->get()->toArray();
    $empresas = implode(",", array_values(array_column($empresas ,"id")));
    $response = DB::select("SELECT id,nombre FROM usuarios WHERE email = '$email' AND id NOT IN (SELECT usuario_id FROM usuarios_empresas WHERE empresa_id in ($empresas))")[0] ?? null;
    return  response()->json($response);
  }
}
