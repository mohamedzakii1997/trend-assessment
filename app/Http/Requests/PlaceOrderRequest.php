<?php

namespace App\Http\Requests;

use App\Rules\CheckStock;
use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

class PlaceOrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'products' => ['required', 'array', 'min:1'],
            'products.*.product_id' => ['required', 'exists:products,id'],
            'products.*.quantity' => [
                'required',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) {

                    $index = explode('.', $attribute)[1];
                    $productId = $this->products[$index]['product_id'];
                    $rule = new CheckStock($productId, $value);
                    $rule->validate($attribute, $value, $fail);
                }
            ],

        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }



    public function messages()
    {
        return [
            'products.required' => 'You must provide at least one product.',
            'products.*.product_id.required' => 'Product ID is required.',
            'products.*.product_id.exists' => 'The selected product does not exist.',
            'products.*.quantity.required' => 'Quantity is required.',
            'products.*.quantity.integer' => 'Quantity must be an integer.',
            'products.*.quantity.min' => 'Quantity must be at least 1.',
        ];
    }


}
