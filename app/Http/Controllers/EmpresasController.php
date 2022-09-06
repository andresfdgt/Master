<?php

namespace App\Http\Controllers;

use App\Models\Empresas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Helpers\CustomResponse;
use App\Helpers\FormatDate;
use App\Models\Usuarios;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class EmpresasController extends Controller
{
  public function index(Request $request)
  {
    if (!$request->ajax()) {
      $modulos = DB::table("modulos")->where("id","<",10000)->get();
      return view('empresas', compact('modulos'));
    } else {

      $empresas = Empresas::join("usuarios_empresas", "usuarios_empresas.empresa_id", "empresas.id")->where("usuarios_empresas.usuario_id", Auth::id())->select("empresas.*")->get();
      $data = array();
      foreach ($empresas as $key => $empresa) {
        $usuarios = '<button class="btn btn-secondary btn-sm mr-1 usuarios" title="Usuarios" id="'.$empresa->id.'" ><i class="fas fa-users"></i></button>';
        $editar =(Auth::user()->existPermission(10053))?'<button class="btn btn-warning btn-sm mr-1 editar" title="Editar" id="' . $empresa->id . '"><i class="fas fa-edit"></i></button>':"";
        if($empresa->estado){
          $estado = (Auth::user()->existPermission(10055))?'<button class="btn btn-success btn-sm mr-1 estado" estado="0" id="' . $empresa->id . '">Activo</button>':'<button class="btn btn-success btn-sm mr-1" disabled>Activo</button>';
        }else{
          $estado = (Auth::user()->existPermission(10055))?'<button class="btn btn-info btn-sm mr-1 estado" estado="1" id="' . $empresa->id . '">Inactivo</button>':'<button class="btn btn-info btn-sm mr-1" disabled>Inactivo</button>';
        }
        $eliminar = (Auth::user()->existPermission(10054))?'<button class="btn btn-danger btn-sm eliminar mr-1" title="Eliminar" id="' . $empresa->id . '"><i class="fas fa-trash"></i></button>':"";
        $opciones = '<div class="d-flex"><div class="m-auto">' . $usuarios . $editar . $eliminar . '</div></div>';
        $subdata = array();
        $subdata[] = $key + 1;
        $subdata[] = ucwords($empresa->nombre);
        $subdata[] = ucwords($empresa->razon_social);
        $subdata[] = $empresa->cif;
        $subdata[] = $empresa->direccion;
        $subdata[] = $empresa->telefono;
        $subdata[] = FormatDate::format($empresa->created_at);
        $subdata[] = $estado;
        $subdata[] = $opciones;
        $data[] = $subdata;
      }
      return response()->json(array("data" => $data));
    }
  }
  public function crear()
  {
    return view('crear_Empresa');
  }
  public function store(Request $request)
  {
    $validator =  Validator::make($request->all(), [
      'nombre' => 'required',
      'razon_social' => 'required',
      'cif' => 'required',
      'direccion' => 'required',
      'pais' => 'required',
      'codigo_postal' => 'required',
      'localidad' => 'required',
      'telefono' => 'required',
      'email' => 'required|email',
    ]);

    if ($validator->fails()) {
      return CustomResponse::error($validator->errors()->first(), 200);
    }
    DB::beginTransaction();
    try {
      $email = strtolower($request->email);
      $fecha_actual = Carbon::now();
      $empresa_id = DB::table("empresas")->insertGetId([
        "nombre" => strtolower($request->nombre),
        "razon_social" => strtolower($request->razon_social),
        "cif" => $request->cif,
        "direccion" => strtolower($request->direccion),
        "pais" => strtolower($request->pais),
        "codigo_postal" => $request->codigo_postal,
        "localidad" => strtolower($request->localidad),
        "email" => $email,
        "telefono" => $request->telefono,
        "contacto" => strtolower($request->contacto),
        "estado" => 1,
        "cliente_id" => Usuarios::clientes(Auth::id()),
        "created_at" => $fecha_actual,
        "updated_at" => $fecha_actual
      ]);

      $modulos = json_decode($request->modulos);
      foreach ($modulos as $modulo) {
        DB::table("modulos_empresas")->insert([
          "modulo_id" => $modulo->id,
          "empresa_id" => $empresa_id
        ]);
      }

      DB::table("usuarios_empresas")->insert([
        "usuario_id" => Auth::id(),
        "empresa_id" => $empresa_id,
      ]);

      $nombre_db = (substr($email, 0, strrpos($email, "@"))) . "_" . $empresa_id;
      $caracteres = array("!", "#", "$", "%", "&", "'", "*", "+", "-", "/", "=", "?", "^", "`", "á","é", "í", "ó", "ú",  "{", "|", "}", "~", "(", ")", ",", ":", ";", "<", ">", "[", "]", ".");
      $nombre_db = str_replace($caracteres, "", $nombre_db);
      if(Auth::user()->last_empresa_id != 0 && Auth::user()->last_empresa_id != ""){
        DB::table("usuarios")->where("id", Auth::id())->update([
          "last_empresa_id" => $empresa_id,
          "base_datos" => $nombre_db
        ]);
      }
      DB::table("empresas")->where("id", $empresa_id)->update([
        "base_datos" => $nombre_db
      ]);
      DB::select("Call nueva_base_datos('$nombre_db')");
      $request->session()->put('empresas', Usuarios::clientesEmpresas(Auth::id()));
      DB::commit();
      return CustomResponse::success("Empresa registrada correctamente");
    } catch (\Throwable $th) {
      DB::rollBack();
      //return response()->json(array("status" => 'error', "title" => "Oops... Algo salió mal", "message" => $th->getMessage()));
      throw $th;
    }
  }
  public function show($id)
  {
    $empresa = Empresas::find($id);
    $empresa->modulos = DB::table("modulos_empresas as me")->join("modulos as m","me.modulo_id","m.id")->where("empresa_id",$id)->select("m.id","m.nombre")->get();
    return  response()->json($empresa);
  }
  public function roles($id)
  {
    $roles = DB::table("roles_app")->where("empresa_id",$id)->select("id","name")->get();
    return  response()->json($roles);
  }
  public function usuarios($id)
  {
    $usuario_master = DB::select("SELECT u.nombre, u.email,'Activo' as estado,'master' as rol  FROM usuarios as u, usuarios_empresas as ue WHERE  u.id = ue.usuario_id AND ue.rol_id = 0 AND ue.empresa_id = $id")[0];
    $usuarios = DB::select("SELECT u.nombre, u.email,IF(u.estado=1,'Activo','Inactivo') as estado,r.`name` as rol  FROM usuarios as u, usuarios_empresas as ue, roles_app as r WHERE r.id=ue.rol_id AND u.id = ue.usuario_id AND ue.empresa_id = $id");
    array_unshift($usuarios, $usuario_master);
    return  response()->json($usuarios);
  }
  public function update(Request $request)
  {
    $validator =  Validator::make($request->all(), [
      'nombre' => 'required',
      'razon_social' => 'required',
      'cif' => 'required',
      'direccion' => 'required',
      'pais' => 'required',
      'codigo_postal' => 'required',
      'localidad' => 'required',
      'telefono' => 'required',
      'email' => 'required|email',
    ]);
    if ($validator->fails()) {
      return CustomResponse::error($validator->errors()->first(), 200);
    }
    DB::beginTransaction();
    try {
      $fecha_actual = Carbon::now();
      DB::table("empresas")
        ->where("id", $request->id)
        ->update([
          "nombre" => strtolower($request->nombre),
          "razon_social" => strtolower($request->razon_social),
          "cif" => $request->cif,
          "direccion" => strtolower($request->direccion),
          "pais" => strtolower($request->pais),
          "codigo_postal" => $request->codigo_postal,
          "localidad" => strtolower($request->localidad),
          "email" => strtolower($request->email),
          "contacto" => strtolower($request->contacto),
          "updated_at" => $fecha_actual
        ]);
      DB::table("modulos_empresas")->where("empresa_id",$request->id)->delete();
      $modulos = json_decode($request->modulos);
      foreach ($modulos as $modulo) {
        DB::table("modulos_empresas")->insert([
          "modulo_id" => $modulo->id,
          "empresa_id" => $request->id
        ]);
      }
      DB::commit();
      return CustomResponse::success("Empresa actualizada correctamente");
    } catch (\Throwable $th) {
      DB::rollBack();
      throw $th;
    }
  }
  public function delete($id_Empresa)
  {
    try {
      Empresas::findOrFail($id_Empresa)->delete();
      return CustomResponse::success("Empresa eliminada correctamente");
    } catch (ModelNotFoundException $th) {
      return CustomResponse::error("Empresa no encontrada");
    }
  }

  public function estado(Request $request)
  {
    try {
      Empresas::where('id', $request->id)->update(['estado' => $request->estado]);
      return response()->json(array("status" => 'success', "title" => "Buen trabajo", "message" => "Estado de la empresa actualizado correctamente"));
    } catch (ModelNotFoundException | \Exception $th) {
      return response()->json(array("status" => 'error', "title" => "Oops... Algo salió mal", "message" => "Hay un error vuelva a intentarlo"));
    }
  }
}
