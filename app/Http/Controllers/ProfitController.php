<?php
namespace App\Http\Controllers;

use App\Services\ProfitService;
use Illuminate\Http\JsonResponse;

class ProfitController extends Controller
{
    public function profit($batch_id, ProfitService  $profit_service): JsonResponse
    {
        return $profit_service->profit($batch_id);
    }
}

