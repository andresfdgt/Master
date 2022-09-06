<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LocalizacionController extends Controller
{
    public function provinciaLocalidad($codigoPostal)
    {
        $response = [];
        $response['localidad'] = "";
        $response['provincia'] = "";
        $response['localidad_id'] = "";
        $response['provincia_id'] = "";
        DB::beginTransaction();
        $localidadProvincia = DB::table("localidades")
            ->join("provincias", "provincias.id", '=', 'localidades.provincia_id')
            ->where(['localidades.codigo_postal' => $codigoPostal])
            ->get([
                'localidades.id as localidad_id', 'localidades.nombre as localidad',
                'provincias.id as provincia_id', 'provincias.nombre as provincia'
            ])->first();
        if ($localidadProvincia != null) {
            $response['localidad'] = $localidadProvincia->localidad;
            $response['provincia'] = $localidadProvincia->provincia;
            $response['localidad_id'] = $localidadProvincia->localidad_id;
            $response['provincia_id'] = $localidadProvincia->provincia_id;
        }
        return response()->json(array("status" => 'success', "response" => $response));
    }
}
