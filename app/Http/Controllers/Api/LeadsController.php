<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TokenActionService;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Models\LeadModel;


class LeadsController extends Controller
{
    public function __invoke(TokenActionService $service)
    {

        $apiClient = $service->apiClient();

        $leadsService = $apiClient->leads();

        try {
            return $leadsService->get(with: [LeadModel::CONTACTS]);

        } catch (AmoCRMApiException $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'code' => $e->getCode()
            ]);
        }
    }
}
