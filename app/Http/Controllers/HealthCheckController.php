<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use StreetSignal\Core\Tool\Validator\OAuthCredentialValidator;

class HealthCheckController extends Controller
{
    public function __invoke(OAuthCredentialValidator $validator): JsonResponse
    {
        $result = $validator->validate();
        $statusCode = $result['status'] === 'ok' ? 200 : 500;

        return response()->json($result, $statusCode);
    }
}