<?php
namespace App\Http\Controllers;

use App\Http\Requests\ProfitRequest;
use App\Services\ProfitService;
use Illuminate\Http\JsonResponse;

class ProfitController extends Controller
{
    /**
     * @OA\Get(
     *     path="/profit",
     *     operationId="getProfit",
     *     tags={"Profit"},
     *     summary="Get profit",
     *     description="Get profit of each batch",
     *     @OA\Parameter(
     *         name="batch_id",
     *         in="query",
     *         description="Id of Batch",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="batch_id", type="integer", example=1),
     *             @OA\Property(property="batch_price", type="numeric", example="10000.50"),
     *             @OA\Property(property="sales", type="numeric", example="12000.20"),
     *             @OA\Property(property="profit", type="numeric",  example="2000.00")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="This batch does not exist")
     *         )
     *     )
     * )
     */
    public function profit(ProfitRequest $request, ProfitService  $profit_service): JsonResponse
    {
        $validated = $request->validated();
        return $profit_service->profit($validated['batch_id']);
    }
}

