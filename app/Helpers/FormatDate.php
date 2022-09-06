<?php

namespace App\Helpers;

use DateTime;

class FormatDate
{

  public static function format($date, $hour = "")
  {
    $date = new DateTime($date);
    if ($hour){
      return $date->modify(session("utc")." hours")->format(session("formato_fecha")." H:i:s");
    }else{
      return $date->format(session('formato_fecha'));
    }
  }
}
