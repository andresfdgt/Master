<?php

namespace App\Http\Controllers;

use App\Helpers\CustomResponse;
use App\Helpers\FormatDate;
use App\Helpers\Utils;
use App\Models\IvaArticulo;
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

class IvaController extends Controller
{
    public function index_articulos()
    {
        return view('auxiliares.iva_articulos');
    }

    public function ivaArticulos()
    {
        $DB = DB::connection("privada");
        $DB->beginTransaction();
        $ivaArticulos = $DB->table("gen_iva_articulos")->get();
        $data = array();
        foreach ($ivaArticulos as $key => $ivaArticulo) {
            $editar = '<a href="articulos/editar/' . $ivaArticulo->id . '"><button class="btn btn-warning btn-sm mr-1 editar" id="' . $ivaArticulo->id . '"><i class="fas fa-edit"></i></button></a>';
            $eliminar = '<button class="btn btn-danger btn-sm eliminar mr-1" id="' . $ivaArticulo->id . '"><i class="fa fa-fas fa-trash"></i></button>';
            $opciones = '<div class="d-flex">' .  $editar . $eliminar . '</div>';
            $subdata = array();
            $subdata[] = $key + 1;
            $subdata[] = $ivaArticulo->favorito == 1 ? '<i class="fa fa-fas fa-star"></i>' : '<a href="articulos/favorito/' . $ivaArticulo->id . '"><i class="far fa-star"></i></a>';
            $subdata[] = $ivaArticulo->descripcion;
            $subdata[] = number_format($ivaArticulo->iva, 2);
            $subdata[] = number_format($ivaArticulo->recargo, 2);
            $subdata[] = $opciones;
            $data[] = $subdata;
        }
        return response()->json(array("data" => $data));
    }

    public function crear()
    {
        return view('auxiliares.crear_iva_articulo');
    }

    public function editar($id)
    {
        $DB = DB::connection("privada");
        $DB->beginTransaction();
        $ivaArticulo = $DB->table("gen_iva_articulos")->where("id", $id)->first();
        return view('auxiliares.editar_iva_articulo', compact("ivaArticulo"));
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
            $hay_favorito = $DB->table('gen_iva_articulos')->where('favorito', 1)->first();
            if ((isset($request->favorito) && $request->favorito == 1) || $hay_favorito == null) {
                $favorito = 1;
            }
            if ($hay_favorito != null && $favorito == 1) {
                $DB->table('gen_iva_articulos')
                    ->where("id", $hay_favorito->id)
                    ->update([
                        "favorito" => 0,
                        "updated_at" => $fecha_actual
                    ]);
            }
            $id_iva_articulo = $DB->table('gen_iva_articulos')
                ->insertGetId([
                    "descripcion" => $request->descripcion,
                    "favorito" => $favorito,
                    "iva" => $request->iva,
                    "recargo" => $request->recargo,
                    "created_at" => $fecha_actual,
                    "updated_at" => $fecha_actual
                ]);
            $DB->commit();
            return response()->json(array("status" => 'success', "title" => "Buen trabajo", "message" => "IVA de artículo creado exitosamente"));
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
            $hay_favorito = $DB->table('gen_iva_articulos')->where('favorito', 1)->where('id', '!=', $request->id)->first();
            if ((isset($request->favorito) && $request->favorito == 1) || $hay_favorito == null) {
                $favorito = 1;
            }
            if ($hay_favorito != null && $favorito == 1) {
                $DB->table('gen_iva_articulos')
                    ->where("id", $hay_favorito->id)
                    ->update([
                        "favorito" => 0,
                        "updated_at" => $fecha_actual
                    ]);
            }

            $DB->table('gen_iva_articulos')
                ->where("id", $request->id)
                ->update([
                    "descripcion" => $request->descripcion,
                    "favorito" => $favorito,
                    "iva" => $request->iva,
                    "recargo" => $request->recargo,
                    "updated_at" => $fecha_actual
                ]);
            $DB->commit();
            return response()->json(array("status" => 'success', "title" => "Buen trabajo", "message" => "IVA de artículo editado exitosamente"));
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
            $quita_favorito = $DB->table('gen_iva_articulos')
                ->where("id", '!=', $request->id)
                ->where('favorito', 1)
                ->update([
                    "favorito" => 0,
                    "updated_at" => $fecha_actual
                ]);

            $DB->table('gen_iva_articulos')
                ->where("id", $request->id)
                ->update([
                    "favorito" => 1,
                    "updated_at" => $fecha_actual
                ]);
            $DB->commit();
            return redirect('iva/articulos');
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
            $DB->table("gen_iva_articulos")->where("id", $id)->delete();
            $hay_favorito = $DB->table('gen_iva_articulos')->where('favorito', 1)->first();
            if ($hay_favorito == null) {
                $nuevo_favorito = $DB->table('gen_iva_articulos')->first();
                $DB->table('gen_iva_articulos')
                    ->where('id', $nuevo_favorito->id)
                    ->update(
                        ['favorito' => 1]
                    );
            }
            $DB->commit();
            return CustomResponse::success("IVA de artículo eliminado correctamente");
        } catch (ModelNotFoundException $th) {
            $DB->rollBack();
            return CustomResponse::error("IVA de artículo no encontrado");
        }
    }

    public function index_clientes()
    {
        return view('auxiliares.iva_clientes');
    }

    public function ivaClientes()
    {
        $DB = DB::connection("privada");
        $DB->beginTransaction();
        $ivaClientes = $DB->table("gen_iva_clientes")->get();
        $data = array();
        foreach ($ivaClientes as $key => $ivaCliente) {
            $editar = '<a href="clientes/editar/' . $ivaCliente->id . '"><button class="btn btn-warning btn-sm mr-1 editar" id="' . $ivaCliente->id . '"><i class="fas fa-edit"></i></button></a>';
            $eliminar = '<button class="btn btn-danger btn-sm eliminar mr-1" id="' . $ivaCliente->id . '"><i class="fa fa-fas fa-trash"></i></button>';
            $opciones = '<div class="d-flex">' .  $editar . $eliminar . '</div>';
            $subdata = array();
            $subdata[] = $key + 1;
            $subdata[] = $ivaCliente->favorito == 1 ? '<i class="fa fa-fas fa-star"></i>' : '<a href="clientes/favorito/' . $ivaCliente->id . '"><i class="far fa-star"></i></a>';
            $subdata[] = $ivaCliente->descripcion;
            $subdata[] = number_format($ivaCliente->iva, 2);
            $subdata[] = number_format($ivaCliente->recargo, 2);
            $subdata[] = $opciones;
            $data[] = $subdata;
        }
        return response()->json(array("data" => $data));
    }

    public function crearIvaCliente()
    {
        return view('auxiliares.crear_iva_cliente');
    }

    public function editarIvaCliente($id)
    {
        $DB = DB::connection("privada");
        $DB->beginTransaction();
        $ivaCliente = $DB->table("gen_iva_clientes")->where("id", $id)->first();
        return view('auxiliares.editar_iva_cliente', compact("ivaCliente"));
    }

    public function storeIvaCliente(Request $request)
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
            $hay_favorito = $DB->table('gen_iva_clientes')->where('favorito', 1)->first();
            if ((isset($request->favorito) && $request->favorito == 1) || $hay_favorito == null) {
                $favorito = 1;
            }
            if ($hay_favorito != null && $favorito == 1) {
                $DB->table('gen_iva_clientes')
                    ->where("id", $hay_favorito->id)
                    ->update([
                        "favorito" => 0,
                        "updated_at" => $fecha_actual
                    ]);
            }
            $id_iva_articulo = $DB->table('gen_iva_clientes')
                ->insertGetId([
                    "descripcion" => $request->descripcion,
                    "favorito" => $favorito,
                    "iva" => $request->iva,
                    "recargo" => $request->recargo,
                    "observaciones" => $request->observaciones,
                    "created_at" => $fecha_actual,
                    "updated_at" => $fecha_actual
                ]);
            $DB->commit();
            return response()->json(array("status" => 'success', "title" => "Buen trabajo", "message" => "IVA de artículo creado exitosamente"));
        } catch (\Exception $e) {
            $DB->rollback();
            return response()->json(array("status" => 'error', "title" => "Oops... Algo salió mal", "message" => $e->getMessage()));
        }
    }

    public function updateIvaCliente(Request $request)
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
            $hay_favorito = $DB->table('gen_iva_clientes')->where('favorito', 1)->where('id', '!=', $request->id)->first();
            if ((isset($request->favorito) && $request->favorito == 1) || $hay_favorito == null) {
                $favorito = 1;
            }
            if ($hay_favorito != null && $favorito == 1) {
                $DB->table('gen_iva_clientes')
                    ->where("id", $hay_favorito->id)
                    ->update([
                        "favorito" => 0,
                        "updated_at" => $fecha_actual
                    ]);
            }

            $DB->table('gen_iva_clientes')
                ->where("id", $request->id)
                ->update([
                    "descripcion" => $request->descripcion,
                    "favorito" => $favorito,
                    "iva" => $request->iva,
                    "recargo" => $request->recargo,
                    "observaciones" => $request->observaciones,
                    "updated_at" => $fecha_actual
                ]);
            $DB->commit();
            return response()->json(array("status" => 'success', "title" => "Buen trabajo", "message" => "IVA de artículo editado exitosamente"));
        } catch (\Exception $e) {
            $DB->rollback();
            return response()->json(array("status" => 'error', "title" => "Oops... Algo salió mal", "message" => $e->getMessage()));
        }
    }

    public function updateFavoritoIvaCliente(Request $request)
    {
        $fecha_actual = Carbon::now();
        $DB = DB::connection("privada");
        $DB->beginTransaction();
        try {
            $quita_favorito = $DB->table('gen_iva_clientes')
                ->where("id", '!=', $request->id)
                ->where('favorito', 1)
                ->update([
                    "favorito" => 0,
                    "updated_at" => $fecha_actual
                ]);

            $DB->table('gen_iva_clientes')
                ->where("id", $request->id)
                ->update([
                    "favorito" => 1,
                    "updated_at" => $fecha_actual
                ]);
            $DB->commit();
            return redirect('iva/clientes');
        } catch (\Exception $e) {
            $DB->rollback();
            return response()->json(array("status" => 'error', "title" => "Oops... Algo salió mal", "message" => $e->getMessage()));
        }
    }

    public function deleteIvaCliente($id)
    {
        $DB = DB::connection("privada");
        $DB->beginTransaction();
        try {
            $DB->table("gen_iva_clientes")->where("id", $id)->delete();
            $hay_favorito = $DB->table('gen_iva_clientes')->where('favorito', 1)->first();
            if ($hay_favorito == null) {
                $nuevo_favorito = $DB->table('gen_iva_clientes')->first();
                $DB->table('gen_iva_clientes')
                    ->where('id', $nuevo_favorito->id)
                    ->update(
                        ['favorito' => 1]
                    );
            }
            $DB->commit();
            return CustomResponse::success("IVA de cliente eliminado correctamente");
        } catch (ModelNotFoundException $th) {
            $DB->rollBack();
            return CustomResponse::error("IVA de cliente no encontrado");
        }
    }
}
