<?php

namespace App\Services;





use App\Events\OrderPlaced;
use App\Repositories\OrderProductRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Resources\OrderResource;
use App\Resources\ProductResource;
use App\Resources\UserResource;
use App\Traits\ApiResponses;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;




class OrderService extends LaravelServiceClass
{
    use ApiResponses;
    private $order_repo;
    private $order_product_repo;
    private $product_repo;

    public function __construct(OrderRepository $order_repo , OrderProductRepository $order_product_repo , ProductRepository $product_repo)
    {
        $this->order_repo = $order_repo;
        $this->order_product_repo = $order_product_repo;
        $this->product_repo = $product_repo;
    }

    public function index()
    {

        if (request('is_pagination')) {
            list($items, $pagination) = parent::paginate($this->product_repo, false);
        } else {
            $items = parent::list($this->product_repo, false);
            $pagination = null;
        }

        $items->load(['category']);

        return $this->ok('products list',ProductResource::collection($items),$pagination);

    }

    public function placeOrder($request = null)
    {
        return    DB::transaction(function() use($request) {

            $validatedData = $request->validated();

            $products = $validatedData['products'];


            $order = $this->order_repo->create(['user_id'=>auth()->user()->id,'amount'=>0]);

            $this->addProductsToOrder($order,$products);


            $order->load(['user','products']);
            // send notification to admin
            event(new OrderPlaced($order));
            return $this->ok('order created',OrderResource::make($order));
        });

    }

    protected function addProductsToOrder($order,$products)
    {

        $totalPrice = 0;

        foreach ($products as $product) {

            $productData = $this->product_repo->get($product['product_id']) ;


            $productData->decrement('stock', $product['quantity']);


            $unitPrice = $productData->price;
            $totalPrice += $unitPrice * $product['quantity'];


            $order->products()->attach($product['product_id'], [
                'quantity' => $product['quantity']
            ]);
        }

        $order->update(['amount' => $totalPrice]);

    }

    public function show($id)
    {


        $order = $this->order_repo->get($id);
        $order->load(['user','products']);
        if (Gate::denies('view', $order)) {
            return $this->error('You are not authorized to view this order.',422);
        }
        $order = OrderResource::make($order);
        return $this->ok('order display',$order);
    }








}
