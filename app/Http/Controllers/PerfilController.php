<?php

namespace App\Http\Controllers;

use App\Helpers\CustomResponse;
use App\Helpers\FormatDate;
use App\Helpers\Utils;
use App\Models\Roles;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class PerfilController extends Controller
{
    public function index()
    {
        return view('perfil');
    }

    public function configuracion()
    {
        $configuracion = DB::table("configuracion")->where("empresa_id", Auth::user()->last_empresa_id)->first();
        $paises = DB::table("paises")->orderBy("nombre")->get();
        return view('configuracion', compact("configuracion", "paises"));
    }

    public function configuracionUpdate(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'formato_fecha' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'title' => "Oops... Algo salió mal",
                'message' => $validator->errors()->first()
            ]);
        }
        try {
            $empresa_id = Auth::user()->last_empresa_id;
            $url_logo =    DB::table('configuracion')->where('empresa_id', $empresa_id)->first()->logo;
            if ($request->hasFile('logo')) {
                $nombre_logo = 'logo_' . time() . '.jpg';
                $type = "empresas/";
                Utils::uploadFile($request->file('logo'), $nombre_logo, $type, $empresa_id);
                $url_logo = $type  . $empresa_id . "/" . $nombre_logo;
            }
            DB::table('configuracion')
                ->where("empresa_id", $empresa_id)
                ->update([
                    "formato_fecha" => $request->formato_fecha,
                    "pais_id" => $request->pais,
                    "decimales" => $request->decimales,
                    "logo" => $url_logo,
                    "updated_at" => Carbon::now()->format("Y-m-d H:i:s")
                ]);
            $request->session()->put('formato_fecha', $request->formato_fecha);
            $request->session()->put('utc', DB::table("paises")->where("id", $request->pais)->first()->utc);
            $request->session()->put('decimales', $request->decimales);
            return response()->json(array("status" => 'success', "title" => "Buen trabajo", "message" => "Datos actualizados correctamente"));
        } catch (\Exception $e) {
            return response()->json(array("status" => 'error', "title" => "Oops... Algo salió mal", "message" => $e->getMessage()));
        }
    }

    public function update(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'nombre' => 'required',
            'password' => 'required|min:6',
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
            DB::table('usuarios')->where("id", Auth::id())
                ->update([
                    "nombre" => strtolower($request->nombre),
                    "password" => Hash::make($request->password),
                    "updated_at" => Carbon::now()->format("Y-m-d H:i:s")
                ]);

            DB::commit();
            return response()->json(array("status" => 'success', "title" => "Buen trabajo", "message" => "Datos actualizados correctamente"));
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(array("status" => 'error', "title" => "Oops... Algo salió mal", "message" => $e->getMessage()));
        }
    }


    public function roles()
    {
        $roles = Roles::where("empresa_id", Auth::user()->last_empresa_id)->get();
        $data = array();
        foreach ($roles as $key => $rol) {

            $editar = '<a href="configuracion/roles/editar/' . $rol->id . '"><button class="btn btn-warning btn-sm mr-1 editar" id="' . $rol->id . '"><i class="fas fa-edit"></i></button></a>';
            $eliminar = '<button class="btn btn-danger btn-sm eliminar mr-1" id="' . $rol->id . '"><i class="fa fa-fas fa-trash"></i></button>';
            $opciones = '<div class="d-flex">' .  $editar . $eliminar . '</div>';
            $subdata = array();
            $subdata[] = $key + 1;
            $subdata[] = ucwords($rol->name);
            $subdata[] = FormatDate::format($rol->created_at);
            $subdata[] = "";
            $subdata[] = $opciones;
            $data[] = $subdata;
        }
        return response()->json(array("data" => $data));
    }

    public function crearRol()
    {
        $modulos = DB::select("SELECT m.id, m.nombre FROM modulos as m,modulos_empresas as me WHERE (m.id = me.modulo_id AND me.empresa_id = " . Auth::user()->last_empresa_id . ") OR m.id = 10000 group by m.id");
        $modulos = array_map(function ($modulo) {
            $permisos = Permission::where("modulo_id", $modulo->id)->select("id", "name", "grupo")->get()->toArray();
            $permisos = $this->agrupar("grupo", $permisos);
            return [
                "id" => $modulo->id,
                "nombre" => $modulo->nombre,
                "permisos" => $permisos
            ];
        }, $modulos);
        return view('crear_rol', compact("modulos"));
    }

    public function editarRol($id)
    {
        $modulos = DB::select("SELECT m.id, m.nombre FROM modulos as m,modulos_empresas as me WHERE (m.id = me.modulo_id AND me.empresa_id = " . Auth::user()->last_empresa_id . ") OR m.id = 10000 group by m.id");
        $modulos = array_map(function ($modulo) {
            $permisos = Permission::where("modulo_id", $modulo->id)->select("id", "name", "grupo")->get()->toArray();
            $permisos = $this->agrupar("grupo", $permisos);
            return [
                "id" => $modulo->id,
                "nombre" => $modulo->nombre,
                "permisos" => $permisos
            ];
        }, $modulos);
        $nombre = DB::table("roles_app")->where("id", $id)->select("name")->first()->name;
        $permisos_roles = DB::table("roles_permisos")->where("role_id", $id)->select("permission_id")->get();
        return view('editar_rol', compact("modulos", "id", "nombre", "permisos_roles"));
    }

    private function agrupar($key, $data)
    {
        $result = array();

        foreach ($data as $val) {
            if (array_key_exists($key, $val)) {
                $result[$val[$key]][] = $val;
            } else {
                $result[""][] = $val;
            }
        }

        return $result;
    }
    public function storeRol(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'nombre' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'title' => "Oops... Algo salió mal",
                'message' => $validator->errors()->first()
            ]);
        }
        $fecha_actual = Carbon::now();
        DB::beginTransaction();
        try {
            $id_rol = DB::table('roles_app')
                ->insertGetId([
                    "name" => $request->nombre,
                    "empresa_id" => Auth::user()->last_empresa_id,
                    "created_at" => $fecha_actual,
                    "updated_at" => $fecha_actual
                ]);
            $permisos = [];
            foreach ($request->permisos as $permiso) {
                $permisos[] = [
                    "permission_id" => $permiso,
                    "role_id" => $id_rol
                ];
            }
            DB::table('roles_permisos')->insert($permisos);
            DB::commit();
            return response()->json(array("status" => 'success', "title" => "Buen trabajo", "message" => "Rol creado exitosamente"));
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(array("status" => 'error', "title" => "Oops... Algo salió mal", "message" => $e->getMessage()));
        }
    }

    public function updateRol(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'nombre' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'title' => "Oops... Algo salió mal",
                'message' => $validator->errors()->first()
            ]);
        }
        $fecha_actual = Carbon::now();
        DB::beginTransaction();
        try {
            DB::table('roles_app')
                ->where("id", $request->id)
                ->update([
                    "name" => $request->nombre,
                    "updated_at" => $fecha_actual
                ]);
            $permisos = [];
            DB::table("roles_permisos")->where("role_id", $request->id)->delete();
            foreach ($request->permisos as $permiso) {
                $permisos[] = [
                    "permission_id" => $permiso,
                    "role_id" => $request->id
                ];
            }
            DB::table('roles_permisos')->insert($permisos);
            $this->reasignarPermisosRolUsuario($request->id);

            DB::commit();
            return response()->json(array("status" => 'success', "title" => "Buen trabajo", "message" => "Rol editado exitosamente"));
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(array("status" => 'error', "title" => "Oops... Algo salió mal", "message" => $e->getMessage()));
        }
    }

    private function reasignarPermisosRolUsuario($id)
    {
        $empresa_id = Auth::user()->last_empresa_id;
        $usuarios = DB::table("usuarios_empresas as ue")->join("roles_app as r", "r.id", "ue.rol_id")->where("ue.empresa_id", $empresa_id)->where("r.id", $id)->select("ue.usuario_id")->get();
        $permisos_rol = DB::table("roles_permisos")->where("role_id", $id)->select("permission_id")->get();
        foreach ($usuarios as $usuario) {
            DB::table("model_has_permissions")->where("model_id", $usuario->usuario_id)->where("empresa_id", $empresa_id)->delete();
            $permisos = [];
            foreach ($permisos_rol as $permiso_rol) {
                $permisos[] = [
                    "permission_id" => $permiso_rol->permission_id,
                    "model_type" => "App\Models\User",
                    "model_id" => $usuario->usuario_id,
                    "empresa_id" => $empresa_id
                ];
            }
            DB::table('model_has_permissions')
                ->insert($permisos);
        }
    }

    public function deleteRol($id)
    {
        DB::beginTransaction();
        try {
            DB::table("roles_app")->where("id", $id)->delete();
            DB::table("roles_permisos")->where("role_id", $id)->delete();
            DB::commit();
            return CustomResponse::success("Rol eliminado correctamente");
        } catch (ModelNotFoundException $th) {
            DB::rollBack();
            return CustomResponse::error("Rol no encontrado");
        }
    }
}
