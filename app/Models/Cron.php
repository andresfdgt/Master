<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cron extends Model
{
    use HasFactory;

    public static function descontarDias(){
        DB::select("UPDATE usuarios as u,iglesias as i SET u.estado_iglesia=3 WHERE (i.plan_id=1 OR i.plan_id=19) AND u.iglesia_id=i.id AND i.dias_disponibles_plan=0");
        DB::select("UPDATE usuarios as u,iglesias as i SET u.estado_iglesia=3 WHERE u.iglesia_id=i.id AND i.dias_disponibles_plan=-5");
        DB::select("UPDATE usuarios as u,iglesias as i SET u.estado_iglesia=2 WHERE u.iglesia_id=i.id AND i.dias_disponibles_plan=0");
        DB::table("iglesias")->where("plan_id","!=",1)->where("plan_id","!=",19)->where("dias_disponibles_plan",">",-5)->decrement("dias_disponibles_plan");
        DB::table("iglesias")->where("dias_disponibles_plan",">",0)->where(function($query){$query->where("plan_id",1)->orWhere("plan_id",19);})->decrement("dias_disponibles_plan");
    }
}
