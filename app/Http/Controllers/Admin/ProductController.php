<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\PaginationRequest;
use App\Http\Requests\ProductRequest;
use App\Services\ProductService;


class ProductController extends Controller
{


    private $product_service;

    public function __construct(ProductService $product_service)
    {
        $this->product_service = $product_service;

    }


    public function index(PaginationRequest $request)
    {
        return $this->product_service->index();
    }

    public function store(ProductRequest $request)
    {
        return $this->product_service->store($request);
    }


    public function show($id)
    {
        return $this->product_service->show($id);
    }

    public function update(ProductRequest $request, $id)
    {
        return $this->product_service->update($id, $request);
    }

    public function destroy($id)
    {
        return $this->product_service->delete($id);
    }
}
