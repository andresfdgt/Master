<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EstadoPlan
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
        
        // if (Auth::user()->estado_iglesia == 4) {
        //     if (Auth::user()->perfil == 'Administrador Principal') {
        //         return redirect()->route('pagos');
        //     }else{
        //         return redirect()->route('plan.inactive');
        //     }
        // }

        return $next($request);
    }
}
