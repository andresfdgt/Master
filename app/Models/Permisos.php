<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class Permisos extends Model
{
  public static function run()
  {
    // dd(User::find(1)->can('eliminar_reunion_de_pareja'));
    Permission::create(['name' => 'ingredientes',"modulo_id" => 1,"grupo"=>1]);
    Permission::create(['name' => 'crear_ingrediente',"modulo_id" => 1,"grupo"=>1]);
    Permission::create(['name' => 'editar_ingrediente',"modulo_id" => 1,"grupo"=>1]);
    Permission::create(['name' => 'eliminar_ingrediente',"modulo_id" => 1,"grupo"=>1]);

    Permission::create(['name' => 'recetas',"modulo_id" => 1,"grupo"=>2]);
    Permission::create(['name' => 'crear_receta',"modulo_id" => 1,"grupo"=>2]);
    Permission::create(['name' => 'editar_receta',"modulo_id" => 1,"grupo"=>2]);
    Permission::create(['name' => 'eliminar_receta',"modulo_id" => 1,"grupo"=>2]);

    Permission::create(['name' => 'repuestos',"modulo_id" => 2,"grupo"=>3]);
    Permission::create(['name' => 'crear_repuesto',"modulo_id" => 2,"grupo"=>3]);
    Permission::create(['name' => 'editar_repuesto',"modulo_id" => 2,"grupo"=>3]);
    Permission::create(['name' => 'eliminar_repuesto',"modulo_id" => 2,"grupo"=>3]);

    Permission::create(['name' => 'ordenes',"modulo_id" => 2,"grupo"=>4]);
    Permission::create(['name' => 'crear_orden',"modulo_id" => 2,"grupo"=>4]);
    Permission::create(['name' => 'editar_orden',"modulo_id" => 2,"grupo"=>4]);
    Permission::create(['name' => 'eliminar_orden',"modulo_id" => 2,"grupo"=>4]);
    // Permission::create(['name' => 'crear_agenda']);
    // Permission::create(['name' => 'actualizar_agenda']);
    // Permission::create(['name' => 'eliminar_agenda']);

    // Permission::create(['name' => 'datos_iglesia']);
    // Permission::create(['name' => 'actualizar_datos_iglesia']);

    // Permission::create(['name' => 'usuarios']);
    // Permission::create(['name' => 'crear_usuario']);
    // Permission::create(['name' => 'actualizar_usuario']);
    // Permission::create(['name' => 'actualizar_estado_usuario']);
    // Permission::create(['name' => 'eliminar_usuario']);

    // Permission::create(['name' => 'estudios']);
    // Permission::create(['name' => 'crear_estudio']);
    // Permission::create(['name' => 'actualizar_estudio']);
    // Permission::create(['name' => 'miembros_del_estudio']);
    // Permission::create(['name' => 'agregar_miembro_al_estudio']);
    // Permission::create(['name' => 'finalizar_miembro_del_estudio']);
    // Permission::create(['name' => 'eliminar_estudio']);

    // Permission::create(['name' => 'jerarquias']);
    // Permission::create(['name' => 'crear_jerarquia']);
    // Permission::create(['name' => 'actualizar_jerarquia']);
    // Permission::create(['name' => 'eliminar_jerarquia']);

    // Permission::create(['name' => 'reuniones_generales']);
    // Permission::create(['name' => 'crear_reunion_general']);
    // Permission::create(['name' => 'editar_reunion_general']);
    // Permission::create(['name' => 'eliminar_reunion_general']);

    // Permission::create(['name' => 'celulas']);
    // Permission::create(['name' => 'crear_celula']);
    // Permission::create(['name' => 'actualizar_celula']);
    // Permission::create(['name' => 'actualizar_estado_de_la_celula']);
    // Permission::create(['name' => 'eliminar_celula']);
    // Permission::create(['name' => 'lideres_de_la_celula']);
    // Permission::create(['name' => 'agregar_lider_a_la_celula']);
    // Permission::create(['name' => 'finalizar_lider_de_la_celula']);
    // Permission::create(['name' => 'miembros_de_la_celula']);
    // Permission::create(['name' => 'agregar_miembro_a_la_celula']);
    // Permission::create(['name' => 'finalizar_miembro_de_la_celula']);
    // Permission::create(['name' => 'asistencias_de_la_celula']);
    // Permission::create(['name' => 'crear_asistencia_de_la_celula']);
    // Permission::create(['name' => 'editar_asistencia_de_la_celula']);
    // Permission::create(['name' => 'eliminar_asistencia_de_la_celula']);

    // Permission::create(['name' => 'conversiones']);
    // Permission::create(['name' => 'crear_conversion']);
    // Permission::create(['name' => 'actualizar_conversion']);
    // Permission::create(['name' => 'eliminar_conversion']);

    // Permission::create(['name' => 'bautizos']);
    // Permission::create(['name' => 'crear_bautizo']);
    // Permission::create(['name' => 'actualizar_bautizo']);
    // Permission::create(['name' => 'eliminar_bautizo']);

    // Permission::create(['name' => 'familias']);
    // Permission::create(['name' => 'crear_familia']);
    // Permission::create(['name' => 'actualizar_familia']);
    // Permission::create(['name' => 'eliminar_familia']);
    // Permission::create(['name' => 'miembros_de_la_familia']);
    // Permission::create(['name' => 'agregar_miembro_a_la_familia']);
    // Permission::create(['name' => 'finalizar_miembro_de_la_familia']);

    // Permission::create(['name' => 'ministerios']);
    // Permission::create(['name' => 'crear_ministerio']);
    // Permission::create(['name' => 'actualizar_ministerio']);
    // Permission::create(['name' => 'eliminar_ministerio']);
    // Permission::create(['name' => 'lideres_del_ministerio']);
    // Permission::create(['name' => 'agregar_lider_al_ministerio']);
    // Permission::create(['name' => 'finalizar_lider_del_ministerio']);
    // Permission::create(['name' => 'miembros_del_ministerio']);
    // Permission::create(['name' => 'agregar_miembro_al_ministerio']);
    // Permission::create(['name' => 'finalizar_miembro_del_ministerio']);
    // Permission::create(['name' => 'reuniones_del_ministerio']);
    // Permission::create(['name' => 'crear_reunion_del_ministerio']);
    // Permission::create(['name' => 'editar_reunion_del_ministerio']);
    // Permission::create(['name' => 'eliminar_reunion_del_ministerio']);
    // Permission::create(['name' => 'planes_de_trabajo']);
    // Permission::create(['name' => 'crear_plan_de_trabajo']);
    // Permission::create(['name' => 'editar_plan_de_trabajo']);
    // Permission::create(['name' => 'eliminar_plan_de_trabajo']);
    // Permission::create(['name' => 'logros_del_plan_de_trabajo']);
    // Permission::create(['name' => 'finalizar_logro_del_plan_de_trabajo']);

    // Permission::create(['name' => 'miembros']);
    // Permission::create(['name' => 'crear_miembro']);
    // Permission::create(['name' => 'actualizar_miembro']);
    // Permission::create(['name' => 'eliminar_miembro']);
    // Permission::create(['name' => 'detalle_miembro']);

    // Permission::create(['name' => 'parejas']);
    // Permission::create(['name' => 'crear_pareja']);
    // Permission::create(['name' => 'actualizar_pareja']);
    // Permission::create(['name' => 'eliminar_pareja']);
    // Permission::create(['name' => 'detalle_pareja']);
    // Permission::create(['name' => 'reuniones_de_parejas']);
    // Permission::create(['name' => 'crear_reunion_de_pareja']);
    // Permission::create(['name' => 'actualizar_reunion_de_pareja']);
    // Permission::create(['name' => 'miembros_de_la_reunion_de_pareja']);

    // Permission::create(['name' => 'movimientos']);
    // Permission::create(['name' => 'crear_movimiento']);
    // Permission::create(['name' => 'actualizar_movimiento']);
    // Permission::create(['name' => 'eliminar_movimiento']);
    // Permission::create(['name' => 'datos_de_movimiento']);

    // Permission::create(['name' => 'difusiones']);
    // Permission::create(['name' => 'crear_difusion']);
    // Permission::create(['name' => 'actualizar_difusion']);
    // Permission::create(['name' => 'eliminar_difusion']);

    // Permission::create(['name' => 'eliminar_reunion_de_pareja']);
  }
}
