<?php

namespace App\Http\Controllers;

use App\Helpers\CustomResponse;
use App\Helpers\FormatDate;
use App\Helpers\Utils;
use App\Models\Marca;
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

class MarcaController extends Controller
{
    public function index()
    {
        return view('auxiliares.marcas');
    }

    public function marcas()
    {
        $DB = DB::connection("privada");
        $DB->beginTransaction();
        $marcas = $DB->table("gen_marcas")->get();
        $data = array();
        foreach ($marcas as $key => $marca) {
            $editar = '<a href="marcas/editar/' . $marca->id . '"><button class="btn btn-warning btn-sm mr-1 editar" id="' . $marca->id . '"><i class="fas fa-edit"></i></button></a>';
            $eliminar = '<button class="btn btn-danger btn-sm eliminar mr-1" id="' . $marca->id . '"><i class="fa fa-fas fa-trash"></i></button>';
            $opciones = '<div class="d-flex">' .  $editar . $eliminar . '</div>';
            $subdata = array();
            $subdata[] = $key + 1;
            $subdata[] = $marca->favorito == 1 ? '<i class="fa fa-fas fa-star"></i>' : '<a href="marcas/favorito/' . $marca->id . '"><i class="far fa-star"></i></a>';
            $subdata[] = ucwords($marca->descripcion);
            $subdata[] = $opciones;
            $data[] = $subdata;
        }
        return response()->json(array("data" => $data));
    }

    public function crear()
    {
        return view('auxiliares.crear_marca');
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
            $hay_favorito = $DB->table('gen_marcas')->where('favorito', 1)->first();
            if ((isset($request->favorito) && $request->favorito == 1) || $hay_favorito == null) {
                $favorito = 1;
            }
            if ($hay_favorito != null && $favorito == 1) {
                $DB->table('gen_marcas')
                    ->where("id", $hay_favorito->id)
                    ->update([
                        "favorito" => 0,
                        "updated_at" => $fecha_actual
                    ]);
            }
            $id_marca = $DB->table('gen_marcas')
                ->insertGetId([
                    "descripcion" => $request->descripcion,
                    "favorito" => $favorito,
                    "observaciones" => $request->observaciones,
                    "created_at" => $fecha_actual,
                    "updated_at" => $fecha_actual
                ]);
            $DB->commit();
            if ($request->hasFile('imagen')) {
                $nombre_imagen = 'marca_' . time() . '.' . $request->file('imagen')->getClientOriginalExtension();
                $carpeta = "marcas/";
                Utils::uploadFile($request->file('imagen'), $nombre_imagen, $carpeta, $id_marca);
                $url_imagen = $carpeta  . $id_marca . "/" . $nombre_imagen;
                $DB->table('gen_marcas')
                    ->where("id", $id_marca)
                    ->update([
                        "imagen" => $url_imagen
                    ]);
            }
            return response()->json(array("status" => 'success', "title" => "Buen trabajo", "message" => "Marca creada exitosamente"));
        } catch (\Exception $e) {
            $DB->rollback();
            return response()->json(array("status" => 'error', "title" => "Oops... Algo salió mal", "message" => $e->getMessage()));
        }
    }

    public function editar($id)
    {
        $DB = DB::connection("privada");
        $DB->beginTransaction();
        $marca = $DB->table("gen_marcas")->where("id", $id)->first();
        return view('auxiliares.editar_marca', compact("marca"));
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
            $hay_favorito = $DB->table('gen_marcas')->where('favorito', 1)->where('id', '!=', $request->id)->first();
            if ((isset($request->favorito) && $request->favorito == 1) || $hay_favorito == null) {
                $favorito = 1;
            }
            if ($hay_favorito != null && $favorito == 1) {
                $DB->table('gen_marcas')
                    ->where("id", $hay_favorito->id)
                    ->update([
                        "favorito" => 0,
                        "updated_at" => $fecha_actual
                    ]);
            }

            if ($request->hasFile('imagen') != null) {
                //Eliminar la imagen anterior
                $url_imagen = $DB->table('gen_marcas')->where("id", $request->id)->first()->imagen;
                if ($url_imagen != "" && $url_imagen != null) {
                    unlink(env('URL_IMAGES') . ($url_imagen));
                    $url_imagen = '';
                }
                //Subir la imagen actual
                $carpeta = "marcas/";
                $nombre_imagen = 'marca_' . time() . '.' . $request->file('imagen')->getClientOriginalExtension();
                Utils::uploadFile($request->file('imagen'), $nombre_imagen, $carpeta, $request->id);
                $url_imagen = $carpeta  . $request->id . "/" . $nombre_imagen;

                $DB->table('gen_marcas')
                    ->where("id", $request->id)
                    ->update([
                        "imagen" => $url_imagen
                    ]);
            }
            if ($request->hasFile('imagen') == null) {
                //Eliminar la imagen anterior si había
                $url_imagen = $DB->table('gen_marcas')->where("id", $request->id)->first()->imagen;
                if ($url_imagen != "" && $url_imagen != null) {
                    unlink(env('URL_IMAGES') . ($url_imagen));
                    $url_imagen = '';
                }
                $DB->table('gen_marcas')
                    ->where("id", $request->id)
                    ->update([
                        "imagen" => NULL
                    ]);
            }
            $DB->table('gen_marcas')
                ->where("id", $request->id)
                ->update([
                    "descripcion" => $request->descripcion,
                    "observaciones" => $request->observaciones,
                    "favorito" => $favorito,
                    "updated_at" => $fecha_actual
                ]);
            $DB->commit();
            return response()->json(array("status" => 'success', "title" => "Buen trabajo", "message" => "Marca editada exitosamente"));
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
            $quita_favorito = $DB->table('gen_marcas')
                ->where("id", '!=', $request->id)
                ->where('favorito', 1)
                ->update([
                    "favorito" => 0,
                    "updated_at" => $fecha_actual
                ]);

            $DB->table('gen_marcas')
                ->where("id", $request->id)
                ->update([
                    "favorito" => 1,
                    "updated_at" => $fecha_actual
                ]);
            $DB->commit();
            return redirect('marcas');
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
            $url_imagen = $DB->table('gen_marcas')->where("id", $id)->first()->imagen;
            if ($url_imagen != "" && $url_imagen != null) {
                unlink(env('URL_IMAGES') . ($url_imagen));
                $url_imagen = '';
            }
            $DB->table("gen_marcas")->where("id", $id)->delete();
            $hay_favorito = $DB->table('gen_marcas')->where('favorito', 1)->first();
            if ($hay_favorito == null) {
                $nuevo_favorito = $DB->table('gen_marcas')->first();
                $DB->update(
                    'update gen_marcas set favorito = 1 where id = ?' , [$nuevo_favorito->id]
                );
            }
            $DB->commit();
            return CustomResponse::success("Marca eliminada correctamente");
        } catch (ModelNotFoundException $th) {
            $DB->rollBack();
            return CustomResponse::error("Marca no encontrada");
        }
    }
}
