<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;

use App\Http\Requests\PaginationRequest;
use App\Http\Requests\ProductRequest;
use App\Services\FrontProductService;



class ProductController extends Controller
{


    private $product_service;

    public function __construct(FrontProductService $product_service)
    {
        $this->product_service = $product_service;

    }


    public function index(PaginationRequest $request)
    {
        return $this->product_service->index();
    }


    public function show($id)
    {
        return $this->product_service->show($id);
    }


}
