<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class BaseDatosPrivada
{
   /**
    * Handle an incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Closure  $next
    * @return mixed
    */
   public function handle(Request $request, Closure $next)
   {
      $auth=Auth::user();
      Config::set('database.connections.privada.database',"db_".$auth->base_datos);
      DB::purge('privada');
      DB::reconnect('privada');
      return $next($request);
   }
}
