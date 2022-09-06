<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class MantenimientoController extends Controller
{
  public function index()
  {
    $empresas = DB::table("empresas")->select("base_datos")->get(); 
    foreach ($empresas as $key => $empresa) {
      try {
        //code...
        // DB::select("CALL alterTable('db_$empresa->base_datos')");
        DB::select("CALL alterTable('$empresa->base_datos')");
        echo "database actualizada <br>";
      } catch (\Throwable $th) {
        echo "database actualizada anteriormente <br>";
      }
    }
  }
}
