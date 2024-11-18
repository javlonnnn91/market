<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
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
        ];
    }
}
