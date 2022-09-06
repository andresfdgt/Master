<?php
 
namespace App\Helpers;

class CustomResponse
{

    public static function error($message, $code = 400){
        return response()->json([
            'status' => 'error',
            'title' => "Oops... Algo salió mal",
            'message' => $message
        ], $code );
    }

    public static function success($message,  $data = null, $code = 200 ) {

        $json = [
            'status' => 'success',
            'title' => "Buen trabajo",
            'message' => $message
        ];

        if ($data){
            $json["data"] = $data;
        }
        
        return response()->json($json, $code );

    }

}