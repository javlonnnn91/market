<?php
namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request, ProductService $product_service)
    {
        $request->validate([
            'batch_id' => 'required|integer'
        ]);
        $batch_id = $request->batch_id;
        return $product_service->products($batch_id);
    }
}
