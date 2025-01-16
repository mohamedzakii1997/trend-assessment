<?php

namespace App\Rules;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckStock implements ValidationRule
{
    protected $productId;
    protected $quantity;

    public function __construct($productId, $quantity)
    {
        $this->productId = $productId;
        $this->quantity = $quantity;
    }


    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        $product = Product::find($this->productId);
        if (!$product) {
            $fail("This product  does not exist.");
            return;
        }
        if (!$product || $product->stock < $this->quantity) {
            $fail("Insufficient stock for product '{$product->name}' ( Available stock: {$product->stock}. )");
        }

    }
}
