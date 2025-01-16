<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;

use App\Http\Requests\PaginationRequest;
use App\Http\Requests\PlaceOrderRequest;
use App\Services\OrderService;


class OrderController extends Controller
{


    private $order_service;

    public function __construct(OrderService $order_service)
    {
        $this->order_service = $order_service;

    }


    public function index(PaginationRequest $request)
    {
        return $this->order_service->index();
    }


    public function show($id)
    {
        return $this->order_service->show($id);
    }

    public function placeOrder(PlaceOrderRequest $request)
    {
        return $this->order_service->placeOrder($request);

    }

}
