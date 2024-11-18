<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RefundRequest extends FormRequest
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
        ];
    }
}
