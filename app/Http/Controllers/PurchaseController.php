<?php
namespace App\Http\Controllers;

use App\Services\PurchaseService;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function store(Request $request, PurchaseService $purchase_service): bool
    {
        $request->validate([
            'provider_id' => 'required',
            'storage_id' => 'required',
            'products' => 'required|array',
            'products.*.product_id' => 'required',
            'products.*.quantity' => 'required|integer',
            'products.*.unit_price' => 'required|numeric',
        ]);

        $data = $request->all();
        return $purchase_service->purchase($data);
    }
}
