<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Usuarios extends Model
{
  use HasFactory;
  use SoftDeletes;
  protected $table = "usuarios";

  public static function clientesEmpresas($id)
  {
    return DB::select("SELECT count(e.id) as cantidad FROM clientes as c, empresas as e WHERE c.id = e.cliente_id AND c.usuario_id = $id")[0]->cantidad;
  }

  public static function clientes($id)
  {
    return DB::select("SELECT id FROM clientes WHERE usuario_id = $id")[0]->id;
  }
}
