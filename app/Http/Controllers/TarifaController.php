<?php

namespace App\Http\Controllers;

use App\Helpers\CustomResponse;
use App\Helpers\FormatDate;
use App\Helpers\Utils;
use App\Models\Tarifa;
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

class TarifaController extends Controller
{
    public function index()
    {
        return view('auxiliares.tarifas');
    }

    public function tarifas()
    {
        $DB = DB::connection("privada");
        $DB->beginTransaction();
        $tarifas = $DB->table("gen_tarifas")->get();
        $data = array();
        foreach ($tarifas as $key => $tarifa) {
            $editar = '<a href="tarifas/editar/' . $tarifa->id . '"><button class="btn btn-warning btn-sm mr-1 editar" id="' . $tarifa->id . '"><i class="fas fa-edit"></i></button></a>';
            $eliminar = '<button class="btn btn-danger btn-sm eliminar mr-1" id="' . $tarifa->id . '"><i class="fa fa-fas fa-trash"></i></button>';
            $opciones = '<div class="d-flex">' .  $editar . $eliminar . '</div>';
            $subdata = array();
            $subdata[] = $key + 1;
            $subdata[] = $tarifa->descripcion;
            switch ($tarifa->tipo) {
                case '%dcto':
                    $subdata[] = '% Descuento sobre precio base';
                    break;
                case 'importe':
                    $subdata[] = 'Importe';
                    break;
                default:
                    $subdata[] = '% Incremento sobre coste';
            }
            $subdata[] = $tarifa->valor;
            $subdata[] = $tarifa->ivaincluido == 'si' ? 'Sí' : 'No';
            $subdata[] = $opciones;
            $data[] = $subdata;
        }
        return response()->json(array("data" => $data));
    }

    public function crear()
    {
        return view('auxiliares.crear_tarifa');
    }

    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'descripcion' => 'required',
            'tipo' => 'required',
            'valor' => 'required'
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
            if (isset($request->ivaincluido) && $request->ivaincluido == 1) {
                $ivaincluido = 'si';
            } else $ivaincluido = 'no';
            $id_tarifa = $DB->table('gen_tarifas')
                ->insertGetId([
                    "descripcion" => $request->descripcion,
                    "tipo" => $request->tipo,
                    "valor" => $request->valor,
                    "ivaincluido" => $ivaincluido,
                    "observaciones" => $request->observaciones,
                    "created_at" => $fecha_actual,
                    "updated_at" => $fecha_actual
                ]);
            $DB->commit();
            return response()->json(array("status" => 'success', "title" => "Buen trabajo", "message" => "Tarifa creada exitosamente"));
        } catch (\Exception $e) {
            $DB->rollback();
            return response()->json(array("status" => 'error', "title" => "Oops... Algo salió mal", "message" => $e->getMessage()));
        }
    }

    public function editar($id)
    {
        $DB = DB::connection("privada");
        $DB->beginTransaction();
        $tarifa = $DB->table("gen_tarifas")->where("id", $id)->first();
        return view('auxiliares.editar_tarifa', compact('tarifa'));
    }

    public function update(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'id' => 'required',
            'descripcion' => 'required',
            'tipo' => 'required',
            'valor' => 'required'
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
        if (isset($request->ivaincluido) && $request->ivaincluido == 1) {
            $ivaincluido = 'si';
        } else $ivaincluido = 'no';
        try {
            $DB->table('gen_tarifas')
                ->where("id", $request->id)
                ->update([
                    "descripcion" => $request->descripcion,
                    "tipo" => $request->tipo,
                    "valor" => $request->valor,
                    "ivaincluido" => $ivaincluido,
                    "observaciones" => $request->observaciones,
                    "updated_at" => $fecha_actual
                ]);
            $DB->commit();
            return response()->json(array("status" => 'success', "title" => "Buen trabajo", "message" => "Tarifa editada exitosamente"));
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
            $DB->table("gen_tarifas")->where("id", $id)->delete();
            $DB->commit();
            return CustomResponse::success("Tarifa eliminada correctamente");
        } catch (ModelNotFoundException $th) {
            $DB->rollBack();
            return CustomResponse::error("Tarifa no encontrada");
        }
    }
}
