<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static function getJsonResponse($message, $data = null, $result = true, $code = 200)
    {
        $response = [
            'message' => $message,
            'data' => $data,
            'result' => $result,
            'code' => $code
        ];
        return response()->json($response, $code);
    }
}
