<?php

namespace App\Models;

use App\Enums\EstadoHotelPlan;
use App\Enums\UserType;
use App\Notifications\ResetPasswordNotification;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles;

  protected $table = "usuarios";

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'nombre',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password',
    'remember_token',
    'activo',
    'deleted_at'
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'email_verified_at' => 'datetime'
  ];

  public function sendPasswordResetNotification($token)
  {
    $this->notify(new ResetPasswordNotification($token));
  }

  public function existPermission($permission_id)
  {
    if ($this->rol == "master") {
      return true;
    } else {
      $existe_admin = DB::table("usuarios_empresas")->where("rol_id", 0)
        ->where("usuario_id", $this->id)->where("empresa_id", $this->last_empresa_id)->first()->id ?? false;

      if ($existe_admin) {
        return true;
      } else {
        return DB::table("model_has_permissions")->where("permission_id", $permission_id)
          ->where("model_id", $this->id)->where("empresa_id", $this->last_empresa_id)->first()->permission_id ?? false;
      }
    }
    return ($this->rol == "master") ? true : DB::table("model_has_permissions")->where("permission_id", $permission_id)
      ->where("model_id", $this->id)->where("empresa_id", $this->last_empresa_id)->first()->permission_id ?? false;
  }

  public function existModule($module_id)
  {
    return  DB::table("modulos_empresas")->where("modulo_id", $module_id)
      ->where("empresa_id", $this->last_empresa_id)->first()->id ?? false;
  }

  public function menu($configuracion = 0)
  {
    $rol = $this->rol;
    $empresa_id = $this->last_empresa_id;
    $rol_privado = DB::table("usuarios_empresas")->where("empresa_id", $empresa_id)->where("usuario_id", $this->id)->select("rol_id")->first();
    $modulos = DB::table("modulos_empresas")->where("empresa_id", $empresa_id)->select("modulo_id")->get()->toArray();
    $modulos = array_values(array_column($modulos, "modulo_id"));
    $modulos[] = 0;

    if ($rol != "master" && $rol_privado->rol_id != 0) {
      $permisos = DB::table("usuarios_empresas as ue")
        ->join("roles_permisos as rp", "rp.role_id", "ue.rol_id")
        ->join("permissions as p", "p.id", "rp.permission_id")
        ->where("ue.empresa_id", $empresa_id)
        ->where("ue.usuario_id", 3)
        ->select("p.id")
        ->get()
        ->toArray();
      $permisos = array_values(array_column($permisos, "id"));
      if(in_array(10000,$permisos)){
        $modulos[] = 10000;
      }
    } else {
      $modulos[] = 10000;
      $permisos = null;
    }
    $padres = $this->queryMenu(0,$configuracion, $modulos);

    foreach ($padres as $key => $padre) {
      if ($padre->url == "#") {

        $padres[$key]->hijos = $this->queryMenu($padre->id,$configuracion, $permisos);
        if(count($padres[$key]->hijos ) == 0){
          unset($padres[$key]);
        }else{
          foreach ($padres[$key]->hijos as $key_hijo => $hijo) {
            if ($hijo->url == "#") {
              $padres[$key]->hijos[$key_hijo]->hijos = $this->queryMenu($hijo->id,$configuracion, $permisos);
              if(count($padres[$key]->hijos[$key_hijo]->hijos) == 0){
                unset($padres[$key]->hijos[$key_hijo]);
              }
            }
          }
        }

      }
    }

    return $padres;
  }


  private function queryMenu($padre_id,$configuracion, $data = null)
  {
    $query = DB::table("menu")
    ->where("padre", $padre_id)
    ->where("configuracion", $configuracion)
    ->where("estado", 1)
    ->where("estado_test", 0);
    if ($data) {
      $query->whereIn("permiso", $data);
    }
    return $query->orderBy("orden")->get();
  }
}
