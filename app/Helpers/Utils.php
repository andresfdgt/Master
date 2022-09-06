<?php

namespace App\Helpers;

class Utils
{

  public static function uploadFile($file, $name, $type, $carpeta = "")
  {
    $file->move(base_path("public/".env("URL_IMAGES") . $type . $carpeta), $name);
  }
}
