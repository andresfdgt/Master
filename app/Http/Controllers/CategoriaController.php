<?php

namespace App\Http\Controllers;

use App\Helpers\CustomResponse;
use App\Helpers\FormatDate;
use App\Helpers\Utils;
use App\Models\Categoria;
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
use App\Http\Controllers\File;

class CategoriaController extends Controller
{
    public function index()
    {
        return view('auxiliares.categorias');
    }

    public function categorias()
    {
        $DB = DB::connection("privada");
        $DB->beginTransaction();
        $categorias_padre = $DB->table("gen_categorias")->whereNull('padre')->orderBy('orden')->get();
        $data = array();
        foreach ($categorias_padre as $categoriaPadre) {
            $editar = '<a href="categorias/editar/' . $categoriaPadre->id . '"><button class="btn btn-warning btn-sm mr-1 editar" id="' . $categoriaPadre->id . '"><i class="fas fa-edit"></i></button></a>';
            $eliminar = '<button class="btn btn-danger btn-sm eliminar mr-1" id="' . $categoriaPadre->id . '"><i class="fa fa-fas fa-trash"></i></button>';
            $opciones = '<div class="d-flex">' .  $editar . $eliminar . '</div>';
            $subdata = array();
            $subdata[] = count($data) + 1;
            $subdata[] = $categoriaPadre->descripcion;
            $subdata[] = $categoriaPadre->slug;
            $subdata[] = $categoriaPadre->aparece_en_web == 1 ? 'Sí' : 'No';
            $subdata[] = $opciones;
            $data[] = $subdata;
            $categorias_hijo = $this->obtenerCategoriasPorPadre($categoriaPadre->id, '', count($data) + 1);
            $data = array_merge($data, $categorias_hijo);
        }
        return response()->json(array("data" => $data));
    }

    private function obtenerCategoriasPorPadre($padre = "", $nivel = "", $orden = 1)
    {
        $DB = DB::connection("privada");
        $DB->beginTransaction();
        if ($padre != '') {
            $categorias = $DB->table("gen_categorias")->where('padre', $padre)->orderBy('orden')->get();
            $nivel .= '-';
        }
        $data = array();
        if ($categorias != null) {
            foreach ($categorias as $categoria) {
                $editar = '<a href="categorias/editar/' . $categoria->id . '"><button class="btn btn-warning btn-sm mr-1 editar" id="' . $categoria->id . '"><i class="fas fa-edit"></i></button></a>';
                $eliminar = '<button class="btn btn-danger btn-sm eliminar mr-1" id="' . $categoria->id . '"><i class="fa fa-fas fa-trash"></i></button>';
                $opciones = '<div class="d-flex">' .  $editar . $eliminar . '</div>';
                $subdata = array();
                $subdata[] = $orden + count($data);
                $subdata[] = $nivel . " " . ucwords($categoria->descripcion);
                $subdata[] = ucwords($categoria->slug);
                $subdata[] = $categoria->aparece_en_web == 1 ? 'Sí' : 'No';
                $subdata[] = $opciones;
                $data[] = $subdata;
                if ($categoria->padre != null) {
                    $categorias_hijo = $this->obtenerCategoriasPorPadre($categoria->id, $nivel, $orden + count($data));
                    if (count($categorias_hijo) >= 1) {
                        $data = array_merge($data, $categorias_hijo);
                    }
                }
            }
        }
        return $data;
    }

    public function categoriasSelect($id = "")
    {
        $DB = DB::connection("privada");
        $DB->beginTransaction();
        if ($id == "") {
            $categorias_padre = $DB->table("gen_categorias")->where('padre', NULL)->orderBy('orden', 'ASC')->get();
        } else {
            $categorias_padre = $DB->table("gen_categorias")->where('id', '!=', $id)->where('padre', NULL)->orderBy('orden', 'ASC')->get();
        }

        $data = array();
        foreach ($categorias_padre as $categoriaPadre) {
            $subdata = $categoriaPadre;
            $subdata->id = $categoriaPadre->id;
            $subdata->descripcion = ucwords($categoriaPadre->descripcion);
            $data[] = $subdata;
            $categorias_hijo = $this->obtenerCategoriasPorPadreSelect($categoriaPadre->id, '');
            $data = array_merge($data, $categorias_hijo);
        }
        return $data;
    }

    private function obtenerCategoriasPorPadreSelect($padre = "", $nivel = "")
    {
        $DB = DB::connection("privada");
        $DB->beginTransaction();
        if ($padre != '') {
            $categorias = $DB->table("gen_categorias")->where('padre', $padre)->orderBy('orden', 'ASC')->get();
            $nivel .= '-';
        }
        $data = array();
        if ($categorias != null) {
            foreach ($categorias as $categoria) {
                $subdata = $categoria;
                $subdata->id = $categoria->id;
                $subdata->descripcion = $nivel . " " . ucwords($categoria->descripcion);
                $data[] = $subdata;
                if ($categoria->padre != null) {
                    $categorias_hijo = $this->obtenerCategoriasPorPadreSelect($categoria->id, $nivel);
                    if (count($categorias_hijo) >= 1) {
                        $data = array_merge($data, $categorias_hijo);
                    }
                }
            }
        }
        return $data;
    }

    public function crear()
    {
        $DB = DB::connection("privada");
        $DB->beginTransaction();
        $categorias = $this->categoriasSelect();
        return view('auxiliares.crear_categoria', compact("categorias"));
    }

    public function editar($id)
    {
        $DB = DB::connection("privada");
        $DB->beginTransaction();
        $categoria = $DB->table("gen_categorias")->where("id", $id)->first();
        $categorias = $this->categoriasSelect($id);
        return view('auxiliares.editar_categoria', compact('categoria', 'categorias'));
    }

    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'descripcion' => 'required',
            'slug' => 'required',
            'orden' => 'required'
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
            $apareceEnWeb = 0;

            if (isset($request->aparece_en_web) && $request->aparece_en_web == 1) {
                $apareceEnWeb = $request->aparece_en_web;
            }

            $id_categoria = $DB->table('gen_categorias')
                ->insertGetId([
                    "descripcion" => $request->descripcion,
                    "aparece_en_web" => $apareceEnWeb,
                    "orden" => $request->orden,
                    "slug" => $request->slug,
                    "padre" => $request->padre,
                    "created_at" => $fecha_actual,
                    "updated_at" => $fecha_actual
                ]);
            $DB->commit();

            if ($request->hasFile('imagen')) {
                $nombre_imagen = 'categoria_' . time() . '.' . $request->file('imagen')->getClientOriginalExtension();
                $carpeta = "categorias/";
                Utils::uploadFile($request->file('imagen'), $nombre_imagen, $carpeta, $id_categoria);
                $url_imagen = $carpeta  . $id_categoria . "/" . $nombre_imagen;
                $DB->table('gen_categorias')
                    ->where("id", $id_categoria)
                    ->update([
                        "imagen" => $url_imagen
                    ]);
            }
            return response()->json(array("status" => 'success', "title" => "Buen trabajo", "message" => "Categoría creada exitosamente"));
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
            'slug' => 'required',
            'orden' => 'required'
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
            $apareceEnWeb = 0;
            if (isset($request->aparece_en_web) && $request->aparece_en_web == 1) {
                $apareceEnWeb = $request->aparece_en_web;
            }

            if (!$request->hasFile('imagen') || ($request->hasFile('imagen') && $request->file('imagen') != null)) {
                //Eliminar la imagen anterior
                $url_imagen = $DB->table('gen_categorias')->where("id", $request->id)->first()->imagen;
                if ($url_imagen != "" && $url_imagen != null) {
                    unlink(env('URL_IMAGES') . ($url_imagen));
                    $url_imagen = null;
                    $DB->table('gen_categorias')
                        ->where("id", $request->id)
                        ->update([
                            "imagen" => $url_imagen
                        ]);
                }
            }

            if ($request->hasFile('imagen') && $request->file('imagen') != null) {
                //Subir la imagen actual
                $carpeta = "categorias/";
                $nombre_imagen = 'categoria_' . time() . '.' . $request->file('imagen')->getClientOriginalExtension();
                Utils::uploadFile($request->file('imagen'), $nombre_imagen, $carpeta, $request->id);
                $url_imagen = $carpeta  . $request->id . "/" . $nombre_imagen;

                $DB->table('gen_categorias')
                    ->where("id", $request->id)
                    ->update([
                        "imagen" => $url_imagen
                    ]);
            }

            $DB->table('gen_categorias')
                ->where("id", $request->id)
                ->update([
                    "descripcion" => $request->descripcion,
                    "aparece_en_web" => $apareceEnWeb,
                    "orden" => $request->orden,
                    "slug" => $request->slug,
                    "padre" => $request->padre,
                    "updated_at" => $fecha_actual
                ]);
            $DB->commit();
            return response()->json(array("status" => 'success', "title" => "Buen trabajo", "message" => "Categoría editada exitosamente"));
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
            $url_imagen = $DB->table('gen_categorias')->where("id", $id)->first()->imagen;
            if ($url_imagen != "" && $url_imagen != null) {
                unlink(env('URL_IMAGES') . ($url_imagen));
                $url_imagen = '';
            }
            $DB->table("gen_categorias")->where("id", $id)->delete();
            $DB->commit();
            return CustomResponse::success("Categoría eliminada correctamente");
        } catch (ModelNotFoundException $th) {
            $DB->rollBack();
            return CustomResponse::error("Categoría no encontrada");
        }
    }
}
