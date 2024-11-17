<?php
namespace App\Http\Controllers;

use App\Services\PurchaseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    /**
     * @OA\Post(
     *     path="/purchase",
     *     operationId="createPurchase",
     *     tags={"Purchase"},
     *     summary="Create a new purchase",
     *     description="Create a new purchase",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"provider_id", "storage_id", "products"},
     *             @OA\Property(
     *                  property="provider_id",
     *                  type="integer",
     *                  example="2"
     *             ),
     *             @OA\Property(
     *                  property="storage_id",
     *                  type="integer",
     *                  example="2"
     *              ),
     *             @OA\Property(
     *                  property="products",
     *                  type="array",
     *                  description="Product details",
     *                  @OA\Items(
     *                      required={"product_id", "quantity", "unit_price"},
     *                      @OA\Property(property="product_id", type="integer", example=1),
     *                      @OA\Property(property="quantity", type="integer", example="2"),
     *                      @OA\Property(property="unit_price", type="numeric", example="1000.00"),
     *                  )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success create",
     *         @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true)
     *         )
     *     ),     *
     *     @OA\Response(
     *          response=400,
     *          description="Error: Bad Request",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Bad Request")
     *          )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error on validation",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Incorrect data.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error in server.")
     *         )
     *     )
     * )
     */
    public function store(Request $request, PurchaseService $purchase_service): JsonResponse
    {
        $request->validate(
            [
                'provider_id' => 'required|integer|exists:providers,id',
                'storage_id' => 'required|integer|exists:storages,id',
                'products' => 'required|array',
                'products.*.product_id' => 'required|integer|exists:products,id',
                'products.*.quantity' => 'required|integer',
                'products.*.unit_price' => 'required|numeric',
            ],
            [
                'provider_id.exists' => 'Provider does not exist',
                'storage_id.exists' => 'Storage does not exist',
                'products.*.product_id.exists' => 'Product does not exist',
            ]
        );

        $data = $request->all();
        return $purchase_service->purchase($data);
    }
}
