<?php
namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    /**
     * @OA\Get(
     *     path="/product",
     *     operationId="getProducts",
     *     tags={"Products"},
     *     summary="Get products",
     *     description="Get list of all available products.",
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
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="product_id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Ahmad TEA"),
     *                     @OA\Property(property="tech_params", type="string", example="Made in England ..."),
     *                     @OA\Property(property="quantity", type="integer",  example="10")
     *                 )
     *             ),
     *             @OA\Property(property="meta", type="object",
     *                 @OA\Property(property="current_page", type="integer", example=1),
     *                 @OA\Property(property="last_page", type="integer", example=1),
     *                 @OA\Property(property="per_page", type="integer", example=10),
     *                 @OA\Property(property="total", type="integer", example=100)
     *             )
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
    public function index(ProductRequest $request, ProductService $product_service): JsonResponse
    {
        $validated = $request->validated();
        return $product_service->products($validated['batch_id']);
    }
}
