<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Miembros;
use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class LoginController extends Controller
{
  public function login()
  {
    return view('auth.login');
  }

  public function authenticate(Request $request)
  {

    $request->validate([
      'correo' => 'required|string|email',
      'password' => 'required|string',
    ]);

    // $credentials = $request->only($this->username(), 'password_proveedor');
    $credentials = ['email' => $request->correo, 'password' => $request->password];
    $recordar = $request->filled('recordar');
    if (Auth::attempt($credentials, $recordar)) {
      $last_login_at = date('Y-m-d H:i:s');
      $last_login_ip = $request->ip();
      DB::table('usuarios')
        ->where("id", Auth::id())
        ->update([
          'last_login_at' => $last_login_at,
          'last_login_ip' => $last_login_ip
        ]);
      $empresas = Usuarios::clientesEmpresas(Auth::id());
      $configuracion = DB::table("configuracion as c")->join("paises as p", "p.id", "c.pais_id")->where("empresa_id", Auth::user()->last_empresa_id)->select("c.formato_fecha", "p.utc", "c.decimales")->first();
      $request->session()->put('formato_fecha', $configuracion->formato_fecha);
      $request->session()->put('utc', $configuracion->utc);
      $request->session()->put('decimales', $configuracion->decimales);
      $request->session()->put('empresas', $empresas);
      if ($empresas == 0 && Auth::user()->rol == "master") {
        return redirect()->intended('empresas');
      }
      return redirect()->intended('dashboard');
    }
    return back()
      ->withErrors(['password' => 'Correo o contraseña incorrectos'])
      ->withInput(request(['correo']));
  }

  public function logout()
  {
    Auth::logout();
    return redirect("/auth");
  }
}
