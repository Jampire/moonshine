<?php

declare(strict_types=1);

namespace Leeto\MoonShine\Traits\Controllers;

use Illuminate\Http\JsonResponse;
use JsonSerializable;

trait ApiResponder
{
    public function jsonResponse(JsonSerializable|array $data): JsonResponse
    {
        return response()->json($data);
    }

    public function jsonSuccessMessage(string $message): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    public function jsonErrorMessage(string $message, int $status = 500): JsonResponse
    {
        return response()->json([
            'success' => false,
            'error' => $message
        ], $status);
    }
}