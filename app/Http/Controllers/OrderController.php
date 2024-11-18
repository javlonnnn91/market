<?php
namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    /**
     * @OA\Post(
     *     path="/order",
     *     operationId="createOrder",
     *     tags={"Order"},
     *     summary="Create new order",
     *     description="Create new order",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"client_id", "products","products.*.product_id"},
     *             @OA\Property(
     *                  property="client_id",
     *                  type="integer",
     *                  example="2"),
     *             @OA\Property(
     *                  property="products",
     *                  type="array",
     *                  description="Product details",
     *                  @OA\Items(
     *                      required={"product_id", "quantity", "batch_id", "storage_id", "price"},
     *                      @OA\Property(property="product_id", type="integer", example=1),
     *                      @OA\Property(property="quantity", type="integer", example="2"),
     *                      @OA\Property(property="batch_id", type="integer", example="1"),
     *                      @OA\Property(property="storage_id", type="integer", example="1"),
     *                      @OA\Property(property="price", type="numeric", example="1000.00"),
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
     *     ),
     *
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

    public function store(OrderRequest $request, OrderService  $order_service): JsonResponse
    {
        $validated = $request->validated();
        return $order_service->order($validated);
    }
}
