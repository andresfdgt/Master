<?php

namespace App\Http\Controllers;

use App\Helpers\CustomResponse;
use App\Helpers\FormatDate;
use App\Helpers\Utils;
use App\Models\AgenciaTransporte;
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

class AgenciaTransporteController extends Controller
{
    public function index()
    {
        return view('auxiliares.agencias_transporte');
    }

    public function agenciasTransporte()
    {
        $DB = DB::connection("privada");
        $DB->beginTransaction();
        $agenciasTranporte = $DB->table("gen_agencias_transporte")->get();
        $data = array();
        foreach ($agenciasTranporte as $key => $agenciaTransporte) {
            $editar = '<a href="agencias_transporte/editar/' . $agenciaTransporte->id . '"><button class="btn btn-warning btn-sm mr-1 editar" id="' . $agenciaTransporte->id . '"><i class="fas fa-edit"></i></button></a>';
            $eliminar = '<button class="btn btn-danger btn-sm eliminar mr-1" id="' . $agenciaTransporte->id . '"><i class="fa fa-fas fa-trash"></i></button>';
            $opciones = '<div class="d-flex">' .  $editar . $eliminar . '</div>';
            $subdata = array();
            $subdata[] = $key + 1;
            $subdata[] = $agenciaTransporte->favorito == 1 ? '<i class="fa fa-fas fa-star"></i>' : '<a href="agencias_transporte/favorito/' . $agenciaTransporte->id . '"><i class="far fa-star"></i></a>';
            $subdata[] = ucwords($agenciaTransporte->descripcion);
            $subdata[] = $opciones;
            $data[] = $subdata;
        }
        return response()->json(array("data" => $data));
    }

    public function crear()
    {
        return view('auxiliares.crear_agencia_transporte');
    }

    public function editar($id)
    {
        $DB = DB::connection("privada");
        $DB->beginTransaction();
        $agenciaTransporte = $DB->table("gen_agencias_transporte")->where("id", $id)->first();
        return view('auxiliares.editar_agencia_transporte', compact("agenciaTransporte"));
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
            $hay_favorito = $DB->table('gen_agencias_transporte')->where('favorito', 1)->first();
            if ((isset($request->favorito) && $request->favorito == 1) || $hay_favorito == null) {
                $favorito = 1;
            }
            if ($hay_favorito != null && $favorito == 1) {
                $DB->table('gen_agencias_transporte')
                    ->where("id", $hay_favorito->id)
                    ->update([
                        "favorito" => 0,
                        "updated_at" => $fecha_actual
                    ]);
            }
            $id_agencia_transporte = $DB->table('gen_agencias_transporte')
                ->insertGetId([
                    "descripcion" => $request->descripcion,
                    "favorito" => $favorito,
                    "observaciones" => $request->observaciones,
                    "created_at" => $fecha_actual,
                    "updated_at" => $fecha_actual
                ]);
            $DB->commit();
            return response()->json(array("status" => 'success', "title" => "Buen trabajo", "message" => "Agencia de transporte creada exitosamente"));
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
            $hay_favorito = $DB->table('gen_agencias_transporte')->where('favorito', 1)->where('id', '!=', $request->id)->first();
            if ((isset($request->favorito) && $request->favorito == 1) || $hay_favorito == null) {
                $favorito = 1;
            }
            if ($hay_favorito != null && $favorito == 1) {
                $DB->table('gen_agencias_transporte')
                    ->where("id", $hay_favorito->id)
                    ->update([
                        "favorito" => 0,
                        "updated_at" => $fecha_actual
                    ]);
            }

            $DB->table('gen_agencias_transporte')
                ->where("id", $request->id)
                ->update([
                    "descripcion" => $request->descripcion,
                    "observaciones" => $request->observaciones,
                    "favorito" => $favorito,
                    "updated_at" => $fecha_actual
                ]);
            $DB->commit();
            return response()->json(array("status" => 'success', "title" => "Buen trabajo", "message" => "Agencia de transporte editada exitosamente"));
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
            $quita_favorito = $DB->table('gen_agencias_transporte')
                ->where("id", '!=', $request->id)
                ->where('favorito', 1)
                ->update([
                    "favorito" => 0,
                    "updated_at" => $fecha_actual
                ]);

            $DB->table('gen_agencias_transporte')
                ->where("id", $request->id)
                ->update([
                    "favorito" => 1,
                    "updated_at" => $fecha_actual
                ]);
            $DB->commit();
            return redirect('agencias_transporte');
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
            $DB->table("gen_agencias_transporte")->where("id", $id)->delete();
            $hay_favorito = $DB->table('gen_agencias_transporte')->where('favorito', 1)->first();
            if ($hay_favorito == null) {
                $nuevo_favorito = $DB->table('gen_agencias_transporte')->first();
                $DB->table('gen_agencias_transporte')
                    ->where('id', $nuevo_favorito->id)
                    ->update(
                        ['favorito' => 1]
                    );
            }
            $DB->commit();
            return CustomResponse::success("Agencia de transporte eliminada correctamente");
        } catch (ModelNotFoundException $th) {
            $DB->rollBack();
            return CustomResponse::error("Agencia de transporte no encontrada");
        }
    }
}
