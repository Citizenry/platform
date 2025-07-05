<?php

namespace StreetSignal\Modules\V5\Http\Controllers;

use Illuminate\Http\JsonResponse;
use StreetSignal\Core\Tool\Validator\OAuthCredentialValidator;
use App\Http\Controllers\Controller;

class HealthCheckController extends Controller
{
    public function __invoke(OAuthCredentialValidator $validator): JsonResponse
    {
        $result = $validator->validate();
        $statusCode = $result['status'] === 'ok' ? 200 : 500;

        return response()->json($result, $statusCode);
    }
}