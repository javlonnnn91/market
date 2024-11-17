<?php
namespace App\Http\Controllers;

use App\Services\RefundService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RefundController extends Controller
{
    /**
     * @OA\Post(
     *     path="/refund",
     *     operationId="createRefund",
     *     tags={"Refund"},
     *     summary="Create a new refund",
     *     description="Create a new refund",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"batch_id", "storage_id", "refund_type", "products"},
     *             @OA\Property(
     *                  property="batch_id",
     *                  type="integer",
     *                  example="2"
     *             ),
     *             @OA\Property(
     *                  property="storage_id",
     *                  type="integer",
     *                  example="2"
     *              ),
     *             @OA\Property(
     *                  property="refund_type",
     *                  type="string",
     *                  enum={"purchase", "sale"},
     *                  example="purchase",
     *                  description="The type of refund, either 'purchase' or 'sale'",
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
     *     ),
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
    public function store(Request $request, RefundService $refund_service): JsonResponse
    {
        $request->validate(
            [
                'batch_id' => 'required|exists:batches,id',
                'storage_id' => 'required|exists:storages,id',
                'refund_type' => 'required|in:purchase,sale',
                'products' => 'required|array',
                'products.*.product_id' => 'required|exists:products,id',
                'products.*.quantity' => 'required|integer',
                'products.*.unit_price' => 'required|numeric',
            ],
            [
                'batch_id.exists' => 'Batch does not exist.',
                'storage_id.exists' => 'Storage does not exist.',
                'refund_type.in' => 'refund_type value must be `purchase` or `sale`.',
                'products.*.product_id.exists' => 'Product does not exist.'
            ]
        );

        $data = $request->all();
        return $refund_service->refund($data);
    }
}
