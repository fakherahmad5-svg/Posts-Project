<?php
namespace App\Services;
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class Responses{
    public static function success($message, $data =[], $status = 200) {
        $response = [$message, $data];
        return response()->json($response, $status);
    }
    public static function fail($message, $error=null, $status = 200)
    {
        $response = [$message, $error];
        return response()->json($response, $status);
    }
}

