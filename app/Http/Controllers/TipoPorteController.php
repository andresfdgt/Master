<?php

namespace App\Http\Controllers;

use App\Helpers\CustomResponse;
use App\Helpers\FormatDate;
use App\Helpers\Utils;
use App\Models\TipoPortes;
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

class TipoPorteController extends Controller
{
    public function index()
    {
        return view('auxiliares.tipo_portes');
    }

    public function tipoPortes()
    {
        $DB = DB::connection("privada");
        $DB->beginTransaction();
        $tipoPortes = $DB->table("gen_tipo_portes")->get();
        $data = array();
        foreach ($tipoPortes as $key => $tipoPorte) {
            $editar = '<a href="tipo_portes/editar/' . $tipoPorte->id . '"><button class="btn btn-warning btn-sm mr-1 editar" id="' . $tipoPorte->id . '"><i class="fas fa-edit"></i></button></a>';
            $eliminar = '<button class="btn btn-danger btn-sm eliminar mr-1" id="' . $tipoPorte->id . '"><i class="fa fa-fas fa-trash"></i></button>';
            $opciones = '<div class="d-flex">' .  $editar . $eliminar . '</div>';
            $subdata = array();
            $subdata[] = $key + 1;
            $subdata[] = $tipoPorte->favorito == 1 ? '<i class="fa fa-fas fa-star"></i>' : '<a href="tipo_portes/favorito/' . $tipoPorte->id . '"><i class="far fa-star"></i></a>';
            $subdata[] = $tipoPorte->descripcion;
            $subdata[] = $opciones;
            $data[] = $subdata;
        }
        return response()->json(array("data" => $data));
    }

    public function crear()
    {
        return view('auxiliares.crear_tipo_porte');
    }

    public function editar($id)
    {
        $DB = DB::connection("privada");
        $DB->beginTransaction();
        $tipoPorte = $DB->table("gen_tipo_portes")->where("id", $id)->first();
        return view('auxiliares.editar_tipo_porte', compact("tipoPorte"));
    }

    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'descripcion' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'title' => "Oops... Algo salió mal",
                'message' => $validator->errors()->first()
            ]);
        }
        $fecha_actual = Carbon::now();
        $DB = DB::connection("privada");
        $DB->beginTransaction();
        try {
            $favorito = 0;
            $hay_favorito = $DB->table('gen_tipo_portes')->where('favorito', 1)->first();
            if ((isset($request->favorito) && $request->favorito == 1) || $hay_favorito == null) {
                $favorito = 1;
            }
            if ($hay_favorito != null && $favorito == 1) {
                $DB->table('gen_tipo_portes')
                    ->where("id", $hay_favorito->id)
                    ->update([
                        "favorito" => 0,
                        "updated_at" => $fecha_actual
                    ]);
            }
            $id_tipo_porte = $DB->table('gen_tipo_portes')
                ->insertGetId([
                    "descripcion" => $request->descripcion,
                    "favorito" => $favorito,
                    "observaciones" => $request->observaciones,
                    "created_at" => $fecha_actual,
                    "updated_at" => $fecha_actual
                ]);
            $DB->commit();
            return response()->json(array("status" => 'success', "title" => "Buen trabajo", "message" => "Tipo de porte creado exitosamente"));
        } catch (\Exception $e) {
            $DB->rollback();
            return response()->json(array("status" => 'error', "title" => "Oops... Algo salió mal", "message" => $e->getMessage()));
        }
    }

    public function update(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'descripcion' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'title' => "Oops... Algo salió mal",
                'message' => $validator->errors()->first()
            ]);
        }
        $fecha_actual = Carbon::now();
        $DB = DB::connection("privada");
        $DB->beginTransaction();
        try {
            $favorito = 0;
            $hay_favorito = $DB->table('gen_tipo_portes')->where('favorito', 1)->where('id', '!=', $request->id)->first();
            if ((isset($request->favorito) && $request->favorito == 1) || $hay_favorito == null) {
                $favorito = 1;
            }
            if ($hay_favorito != null && $favorito == 1) {
                $DB->table('gen_tipo_portes')
                    ->where("id", $hay_favorito->id)
                    ->update([
                        "favorito" => 0,
                        "updated_at" => $fecha_actual
                    ]);
            }

            $DB->table('gen_tipo_portes')
                ->where("id", $request->id)
                ->update([
                    "descripcion" => $request->descripcion,
                    "observaciones" => $request->observaciones,
                    "favorito" => $favorito,
                    "updated_at" => $fecha_actual
                ]);
            $DB->commit();
            return response()->json(array("status" => 'success', "title" => "Buen trabajo", "message" => "Tipo de porte editado exitosamente"));
        } catch (\Exception $e) {
            $DB->rollback();
            return response()->json(array("status" => 'error', "title" => "Oops... Algo salió mal", "message" => $e->getMessage()));
        }
    }

    public function updateFavorito(Request $request)
    {
        $fecha_actual = Carbon::now();
        $DB = DB::connection("privada");
        $DB->beginTransaction();
        try {
            $quita_favorito = $DB->table('gen_tipo_portes')
                ->where("id", '!=', $request->id)
                ->where('favorito', 1)
                ->update([
                    "favorito" => 0,
                    "updated_at" => $fecha_actual
                ]);

            $DB->table('gen_tipo_portes')
                ->where("id", $request->id)
                ->update([
                    "favorito" => 1,
                    "updated_at" => $fecha_actual
                ]);
            $DB->commit();
            return redirect('tipo_portes');
        } catch (\Exception $e) {
            $DB->rollback();
            return response()->json(array("status" => 'error', "title" => "Oops... Algo salió mal", "message" => $e->getMessage()));
        }
    }

    public function delete($id)
    {
        $DB = DB::connection("privada");
        $DB->beginTransaction();
        try {
            $DB->table("gen_tipo_portes")->where("id", $id)->delete();
            $hay_favorito = $DB->table('gen_tipo_portes')->where('favorito', 1)->first();
            if ($hay_favorito == null) {
                $nuevo_favorito = $DB->table('gen_tipo_portes')->first();
                $DB->table('gen_tipo_portes')
                    ->where('id', $nuevo_favorito->id)
                    ->update(
                        ['favorito' => 1]
                    );
            }
            $DB->commit();
            return CustomResponse::success("Tipo de porte eliminado correctamente");
        } catch (ModelNotFoundException $th) {
            $DB->rollBack();
            return CustomResponse::error("Tipo de porte no encontrado");
        }
    }
}
