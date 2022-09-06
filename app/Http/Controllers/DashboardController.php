<?php

namespace App\Http\Controllers;

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
  public function index()
  {
    return view('dashboard');
  }
}
