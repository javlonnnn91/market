<?php
namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request, OrderService  $order_service): bool
    {
        // Валидация входных данных
        $request->validate([
            'client_id' => 'required',
            'products' => 'required|array',
            'products.*.product_id' => 'required',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.batch_id' => 'required',
            'products.*.storage_id' => 'required',
            'products.*.price' => 'required|numeric|min:0',
        ]);

        $data = $request->all();
        return $order_service->order($data);
    }
}
