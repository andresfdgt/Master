<?php

namespace App\Http\Controllers;

use App\Helpers\CustomResponse;
use App\Helpers\FormatDate;
use App\Helpers\Utils;
use App\Models\Numeracion;
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

class NumeracionController extends Controller
{
    public function index()
    {
        return view('auxiliares.numeraciones');
    }

    public function numeraciones()
    {
        $DB = DB::connection("privada");
        $DB->beginTransaction();
        $numeraciones = $DB->table("gen_numeraciones")->get();
        $data = array();
        foreach ($numeraciones as $key => $numeracion) {
            $editar = '<a href="numeraciones/editar/' . $numeracion->id . '"><button class="btn btn-warning btn-sm mr-1 editar" id="' . $numeracion->id . '"><i class="fas fa-edit"></i></button></a>';
            $eliminar = '<button class="btn btn-danger btn-sm eliminar mr-1" id="' . $numeracion->id . '"><i class="fa fa-fas fa-trash"></i></button>';
            $opciones = '<div class="d-flex">' .  $editar . $eliminar . '</div>';
            $subdata = array();
            $subdata[] = $key + 1;
            $subdata[] = $numeracion->favorito == 1 ? '<i class="fa fa-fas fa-star"></i>' : '<a href="numeraciones/favorito/' . $numeracion->id . '"><i class="far fa-star"></i></a>';
            $subdata[] = $numeracion->descripcion;
            $subdata[] = $numeracion->tipo_serie;
            $subdata[] = $numeracion->identificador;
            $subdata[] = $numeracion->siguiente_numero;
            $subdata[] = $numeracion->rellenar_con_ceros == 1 ? 'Sí' : 'No';
            $subdata[] = $numeracion->numero_digitos;
            $subdata[] = $opciones;
            $data[] = $subdata;
        }
        return response()->json(array("data" => $data));
    }

    public function crear()
    {
        return view('auxiliares.crear_numeracion');
    }

    public function editar($id)
    {
        $DB = DB::connection("privada");
        $DB->beginTransaction();
        $numeracion = $DB->table("gen_numeraciones")->where("id", $id)->first();
        return view('auxiliares.editar_numeracion', compact('numeracion'));
    }

    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'descripcion' => 'required',
            'tipo_serie' => 'required',
            'identificador' => 'required',
            'siguiente_numero' => 'required',
            'numero_digitos' => 'required'
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
            $rellenarConCeros = 0;
            $hay_favorito = $DB->table('gen_numeraciones')->where('tipo_serie', $request->tipo_serie)->where('favorito', 1)->first();
            if ((isset($request->favorito) && $request->favorito == 1) || $hay_favorito == null) {
                $favorito = 1;
            }
            if ($hay_favorito != null && $favorito == 1) {
                $DB->table('gen_numeraciones')
                    ->where("id", $hay_favorito->id)
                    ->update([
                        "favorito" => 0,
                        "updated_at" => $fecha_actual
                    ]);
            }

            if (isset($request->rellenar_con_ceros) && $request->rellenar_con_ceros == 1) {
                $rellenarConCeros = $request->rellenar_con_ceros;
            }

            $id_numeracion = $DB->table('gen_numeraciones')
                ->insertGetId([
                    "descripcion" => $request->descripcion,
                    "favorito" => $favorito,
                    "tipo_serie" => $request->tipo_serie,
                    "identificador" => $request->identificador,
                    "siguiente_numero" => $request->siguiente_numero,
                    "rellenar_con_ceros" => $rellenarConCeros,
                    "numero_digitos" => $request->numero_digitos,
                    "observaciones" => $request->observaciones,
                    "created_at" => $fecha_actual,
                    "updated_at" => $fecha_actual
                ]);
            $DB->commit();
            return response()->json(array("status" => 'success', "title" => "Buen trabajo", "message" => "Numeración creada exitosamente"));
        } catch (\Exception $e) {
            $DB->rollback();
            return response()->json(array("status" => 'error', "title" => "Oops... Algo salió mal", "message" => $e->getMessage()));
        }
    }

    public function update(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'id' => 'required',
            'descripcion' => 'required',
            'tipo_serie' => 'required',
            'identificador' => 'required',
            'siguiente_numero' => 'required',
            'numero_digitos' => 'required'
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
            $rellenarConCeros = 0;
            $hay_favorito = $DB->table('gen_numeraciones')->where('tipo_serie', $request->tipo_serie)->where('favorito', 1)->where('id', '!=', $request->id)->first();
            if ((isset($request->favorito) && $request->favorito == 1) || $hay_favorito == null) {
                $favorito = 1;
            }
            if ($hay_favorito != null && $favorito == 1) {
                $DB->table('gen_numeraciones')
                    ->where("id", $hay_favorito->id)
                    ->update([
                        "favorito" => 0,
                        "updated_at" => $fecha_actual
                    ]);
            }
            if (isset($request->rellenar_con_ceros) && $request->rellenar_con_ceros == 1) {
                $rellenarConCeros = $request->rellenar_con_ceros;
            }
            $DB->table('gen_numeraciones')
                ->where("id", $request->id)
                ->update([
                    "descripcion" => $request->descripcion,
                    "favorito" => $favorito,
                    "tipo_serie" => $request->tipo_serie,
                    "identificador" => $request->identificador,
                    "siguiente_numero" => $request->siguiente_numero,
                    "rellenar_con_ceros" => $rellenarConCeros,
                    "numero_digitos" => $request->numero_digitos,
                    "observaciones" => $request->observaciones,
                    "updated_at" => $fecha_actual
                ]);
            $DB->commit();
            return response()->json(array("status" => 'success', "title" => "Buen trabajo", "message" => "Numeración editada exitosamente"));
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
            $quita_favorito = $DB->table('gen_numeraciones')
                ->where("id", '!=', $request->id)
                ->where('favorito', 1)
                ->update([
                    "favorito" => 0,
                    "updated_at" => $fecha_actual
                ]);

            $DB->table('gen_numeraciones')
                ->where("id", $request->id)
                ->update([
                    "favorito" => 1,
                    "updated_at" => $fecha_actual
                ]);
            $DB->commit();
            return redirect('numeraciones');
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
            $tipo_serie = $DB->table("gen_numeraciones")->where("id", $id)->first()->tipo_serie;
            $DB->table("gen_numeraciones")->where("id", $id)->delete();
            $hay_favorito = $DB->table('gen_numeraciones')->where('favorito', 1)->where('tipo_serie', $tipo_serie)->first();
            if ($hay_favorito == null) {
                $nuevo_favorito = $DB->table('gen_numeraciones')->first();
                $DB->table('gen_numeraciones')
                    ->where('id', $nuevo_favorito->id)
                    ->update(
                        ['favorito' => 1]
                    );
            }
            $DB->commit();
            return CustomResponse::success("Numeración eliminada correctamente");
        } catch (ModelNotFoundException $th) {
            $DB->rollBack();
            return CustomResponse::error("Numeración no encontrada");
        }
    }
}
