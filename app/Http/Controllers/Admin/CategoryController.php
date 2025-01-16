<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\PaginationRequest;
use App\Http\Requests\ProductRequest;
use App\Services\CategoryService;


class CategoryController extends Controller
{


    private $category_service;

    public function __construct(CategoryService $category_service)
    {
        $this->category_service = $category_service;

    }


    public function index(PaginationRequest $request)
    {

        return $this->category_service->index();
    }


}
