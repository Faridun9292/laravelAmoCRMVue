<?php

namespace App\Http\Controllers\Api;

use AmoCRM\Exceptions\AmoCRMApiException;
use App\Http\Controllers\Controller;
use App\Services\TokenActionService;

class HistoryController extends Controller
{
    public function __invoke(TokenActionService $service)
    {
        $apiClient = $service->apiClient();

        try {
            return $apiClient->events()->get();
        } catch (AmoCRMApiException $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'code' => $e->getCode()
            ]);
        }
    }
}
