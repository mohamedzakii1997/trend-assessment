<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class OrderProduct extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
    ];


    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function product()
    {

        return $this->belongsTo(Product::class, 'product_id');
    }


}
