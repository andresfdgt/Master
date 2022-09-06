<?php

namespace App\Http\Controllers;

use App\Helpers\CustomResponse;
use App\Helpers\FormatDate;
use App\Helpers\Utils;
use App\Models\FormaPago;
use App\Models\Vencimiento;
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

class FormasPagoController extends Controller
{
    public function index()
    {
        return view('auxiliares.formas_pago');
    }

    public function formasPago()
    {
        $DB = DB::connection("privada");
        $DB->beginTransaction();
        $formasPago = $DB->table("gen_formas_pago")->get();
        $data = array();
        foreach ($formasPago as $key => $formaPago) {
            $editar = '<a href="formas_pago/editar/' . $formaPago->id . '"><button class="btn btn-warning btn-sm mr-1 editar" id="' . $formaPago->id . '"><i class="fas fa-edit"></i></button></a>';
            $eliminar = '<button class="btn btn-danger btn-sm eliminar mr-1" id="' . $formaPago->id . '"><i class="fa fa-fas fa-trash"></i></button>';
            $opciones = '<div class="d-flex">' .  $editar . $eliminar . '</div>';
            $subdata = array();
            $subdata[] = $key + 1;
            $subdata[] = $formaPago->favorito == 1 ? '<i class="fa fa-fas fa-star"></i>' : '<a href="formas_pago/favorito/' . $formaPago->id . '"><i class="far fa-star"></i></a>';
            $subdata[] = $formaPago->remesable == 1 ? '<a href="formas_pago/remesable/' . $formaPago->id . '/0"><i class="fa fa-fas fa-star"></i></a>' : '<a href="formas_pago/remesable/' . $formaPago->id . '/1"><i class="far fa-star"></i></a>';
            $subdata[] = $formaPago->a_cartera == 1 ? '<a href="formas_pago/a_cartera/' . $formaPago->id . '/0"><i class="fa fa-fas fa-star"></i></a>' : '<a href="formas_pago/a_cartera/' . $formaPago->id . '/1"><i class="far fa-star"></i></a>';
            $subdata[] = ucwords($formaPago->descripcion);
            $subdata[] = $opciones;
            $data[] = $subdata;
        }
        return response()->json(array("data" => $data));
    }

    public function crear()
    {
        return view('auxiliares.crear_forma_pago');
    }

    public function editar($id)
    {
        $DB = DB::connection("privada");
        $DB->beginTransaction();
        $formaPago = $DB->table("gen_formas_pago")->where("id", $id)->first();
        $vencimientos = $DB->table("gen_vencimientos")->select('id', 'porcentaje', 'dias')->where("forma_pago_id", $id)->get();
        return view('auxiliares.editar_forma_pago', compact("formaPago", "vencimientos"));
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
            $remesable = 0;
            $a_cartera = 0;
            $hay_favorito = $DB->table('gen_formas_pago')->where('favorito', 1)->first();
            if ((isset($request->favorito) && $request->favorito == 1) || $hay_favorito == null) {
                $favorito = 1;
            }
            if (isset($request->remesable) && $request->remesable == 1) {
                $remesable = 1;
            }
            if (isset($request->a_cartera) && $request->a_cartera == 1) {
                $a_cartera = 1;
            }
            if ($hay_favorito != null && $favorito == 1) {
                $DB->table('gen_formas_pago')
                    ->where("id", $hay_favorito->id)
                    ->update([
                        "favorito" => 0,
                        "updated_at" => $fecha_actual
                    ]);
            }
            $id_forma_pago = $DB->table('gen_formas_pago')
                ->insertGetId([
                    "descripcion" => $request->descripcion,
                    "favorito" => $favorito,
                    "remesable" => $remesable,
                    "a_cartera" => $a_cartera,
                    "observaciones" => $request->observaciones,
                    "created_at" => $fecha_actual,
                    "updated_at" => $fecha_actual
                ]);
            $DB->commit();
            return response()->json(array("status" => 'success', "title" => "Buen trabajo", "message" => "Forma de pago creada exitosamente", "id" => $id_forma_pago));
        } catch (\Exception $e) {
            $DB->rollback();
            return response()->json(array("status" => 'error', "title" => "Oops... Algo salió mal", "message" => $e->getMessage()));
        }
    }
    /*
    public function storeVencimiento(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'forma_pago_id' => 'required',
            'porcentaje' =>  'required',
            'dias' =>  'required'
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
            $id_vencimiento = $DB->table('gen_vencimientos')
                ->insertGetId([
                    "porcentaje" => $request->porcentaje,
                    "dias" => $request->dias,
                    "forma_pago_id" => $request->forma_pago_id,
                    "created_at" => $fecha_actual,
                    "updated_at" => $fecha_actual
                ]);
            $DB->commit();
            $vencimientos = $DB->table('gen_vencimientos')->where("forma_pago_id", $request->forma_pago_id)->get();
            return response()->json(array("status" => 'success', "title" => "Buen trabajo", "message" => "Vencimiento creado exitosamente", "data" => $vencimientos));
        } catch (\Exception $e) {
            $DB->rollback();
            return response()->json(array("status" => 'error', "title" => "Oops... Algo salió mal", "message" => $e->getMessage()));
        }
    }
*/
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
            $remesable = 0;
            $a_cartera = 0;
            $hay_favorito = $DB->table('gen_formas_pago')->where('favorito', 1)->where('id', '!=', $request->id)->first();
            if ((isset($request->favorito) && $request->favorito == 1) || $hay_favorito == null) {
                $favorito = 1;
            }
            if (isset($request->remesable) && $request->remesable == 1) {
                $remesable = 1;
            }
            if (isset($request->a_cartera) && $request->a_cartera == 1) {
                $a_cartera = 1;
            }
            if ($hay_favorito != null && $favorito == 1) {
                $DB->table('gen_formas_pago')
                    ->where("id", $hay_favorito->id)
                    ->update([
                        "favorito" => 0,
                        "updated_at" => $fecha_actual
                    ]);
            }

            $DB->table('gen_formas_pago')
                ->where("id", $request->id)
                ->update([
                    "descripcion" => $request->descripcion,
                    "remesable" => $remesable,
                    "a_cartera" => $a_cartera,
                    "observaciones" => $request->observaciones,
                    "favorito" => $favorito,
                    "updated_at" => $fecha_actual
                ]);
            $DB->commit();
            return response()->json(array("status" => 'success', "title" => "Buen trabajo", "message" => "Forma de pago editada exitosamente"));
        } catch (\Exception $e) {
            $DB->rollback();
            return response()->json(array("status" => 'error', "title" => "Oops... Algo salió mal", "message" => $e->getMessage()));
        }
    }

    public function updateVencimiento(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'porcentaje' =>  'required',
            'dias' =>  'required',
            'forma_pago_id' => 'required'
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
            if ($request->id != null) {
                $vencimiento = $DB->table('gen_vencimientos')
                    ->where("id", $request->id)
                    ->update([
                        "porcentaje" => $request->porcentaje,
                        "dias" => $request->dias,
                        "updated_at" => $fecha_actual
                    ]);
            } else {
                $id_vencimiento = $DB->table('gen_vencimientos')
                    ->insertGetId([
                        "porcentaje" => $request->porcentaje,
                        "dias" => $request->dias,
                        "forma_pago_id" => $request->forma_pago_id,
                        "created_at" => $fecha_actual,
                        "updated_at" => $fecha_actual
                    ]);
            }
            $DB->commit();
            $porcentaje_total = $DB->table('gen_vencimientos')->where("forma_pago_id", $request->forma_pago_id)->sum('porcentaje');
            $mensaje_error = "";
            if ($porcentaje_total < 100 || $porcentaje_total > 100) {
                $mensaje_error = "El porcentaje total debe ser del 100%";
            }
            $vencimientos = $DB->table('gen_vencimientos')->where("forma_pago_id", $request->forma_pago_id)->get();
            if ($mensaje_error != "") {
                return response()->json(array("status" => 'error', "title" => "ERROR en vencimientos", "message" => $mensaje_error, "vencimientos" => $vencimientos));
            } else {
                return response()->json(array("status" => 'success', "title" => "Buen trabajo", "message" => "Vencimiento editado exitosamente", "vencimientos" => $vencimientos));
            }
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
            $quita_favorito = $DB->table('gen_formas_pago')
                ->where("id", '!=', $request->id)
                ->where('favorito', 1)
                ->update([
                    "favorito" => 0,
                    "updated_at" => $fecha_actual
                ]);

            $DB->table('gen_formas_pago')
                ->where("id", $request->id)
                ->update([
                    "favorito" => 1,
                    "updated_at" => $fecha_actual
                ]);
            $DB->commit();
            return redirect('formas_pago');
        } catch (\Exception $e) {
            $DB->rollback();
            return response()->json(array("status" => 'error', "title" => "Oops... Algo salió mal", "message" => $e->getMessage()));
        }
    }

    public function updateRemesable(Request $request)
    {
        $fecha_actual = Carbon::now();
        $DB = DB::connection("privada");
        $DB->beginTransaction();
        try {
            $remesable = $request->remesable == '1' ? 1 : 0;
            $DB->table('gen_formas_pago')
                ->where("id", $request->id)
                ->update([
                    "remesable" => $remesable,
                    "updated_at" => $fecha_actual
                ]);
            $DB->commit();
            return redirect('formas_pago');
        } catch (\Exception $e) {
            $DB->rollback();
            return response()->json(array("status" => 'error', "title" => "Oops... Algo salió mal", "message" => $e->getMessage()));
        }
    }

    public function updateACartera(Request $request)
    {
        $fecha_actual = Carbon::now();
        $DB = DB::connection("privada");
        $DB->beginTransaction();
        try {
            $a_cartera = $request->a_cartera == '1' ? 1 : 0;
            $DB->table('gen_formas_pago')
                ->where("id", $request->id)
                ->update([
                    "a_cartera" => $a_cartera,
                    "updated_at" => $fecha_actual
                ]);
            $DB->commit();
            return redirect('formas_pago');
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
            $DB->table("gen_formas_pago")->where("id", $id)->delete();
            $hay_favorito = $DB->table('gen_formas_pago')->where('favorito', 1)->first();
            if ($hay_favorito == null) {
                $nuevo_favorito = $DB->table('gen_formas_pago')->first();
                $DB->table('gen_formas_pago')
                    ->where('id', $nuevo_favorito->id)
                    ->update(
                        ['favorito' => 1]
                    );
            }
            $DB->commit();
            return CustomResponse::success("Forma de pago eliminada correctamente");
        } catch (ModelNotFoundException $th) {
            $DB->rollBack();
            return CustomResponse::error("Forma de pago no encontrada");
        }
    }

    public function deleteVencimiento($id)
    {
        $DB = DB::connection("privada");
        $DB->beginTransaction();
        try {
            $DB->table("gen_vencimientos")->where("id", $id)->delete();
            $DB->commit();
            return CustomResponse::success("Vencimiento eliminado correctamente");
        } catch (ModelNotFoundException $th) {
            $DB->rollBack();
            return CustomResponse::error("Vencimiento no encontrado");
        }
    }
}
