<?php
namespace App\Http\Controllers;

use App\Services\RefundService;
use Illuminate\Http\Request;

class RefundController extends Controller
{
    public function store(Request $request, RefundService $refund_service):bool
    {
        $request->validate([
            'batch_id' => 'required',
            'refund_type' => 'required',
            'products' => 'required|array',
            'products.*.product_id' => 'required',
            'products.*.quantity' => 'required|integer',
        ]);

        $data = $request->all();

        return $refund_service->refund($data);
    }
}
