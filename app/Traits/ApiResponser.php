<?php

namespace App\Traits;

use Illuminate\Http\Response as ResponseAlias;
use Illuminate\Support\Facades\Log;

trait ApiResponser
{
    public function successResponse($mensaje,$data = [], int $code = ResponseAlias::HTTP_OK)
    {
        return response()->json([
            "success" => true,
            "data"  => $data,
            "mensaje" => $mensaje
        ], $code);
    }


    public function errorResponse($mensaje ,$exception = null, $method =null, $code = 422)
    {
        $error = "ERR-".time();

        if($exception != null)
        {
            Log::error([
                "mensaje" => $exception->getMessage(),
                "linea"  => $exception->getLine(),
                "archivo" => $exception->getFile(),
                "método" => $method,
                "codigo" => $error
            ]);
        }

        return response()->json([
            "success" => false,
            "code" => $error,
            "mensaje" => $mensaje,
        ], $code);

    }
}