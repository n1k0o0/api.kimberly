<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class BusinessLogicException extends Exception
{
    public function render(): JsonResponse
    {
        $data['message'] = $this->getMessage();
        return new JsonResponse($data, 400, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}
