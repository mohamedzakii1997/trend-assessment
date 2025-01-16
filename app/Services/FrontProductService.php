<?php

namespace App\Services;


use App\Repositories\ProductRepository;


use App\Resources\FrontProductResource;

use App\Traits\ApiResponses;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;




class FrontProductService extends LaravelServiceClass
{
    use ApiResponses;
    private $product_repo;


    public function __construct(ProductRepository $product_repo)
    {
        $this->product_repo = $product_repo;

    }

    public function index()
    {
        // Fetch parameters from the request
        $searchKey = request()->input('search_key', '');
        $from = request()->input('from', '');
        $to = request()->input('to', '');
        $categoryId = request()->input('category_id', '');
        $page = request()->input('page', 1);
        $is_pagination = request()->input('is_pagination','');
        // Generate a unique cache key based on the parameters
        $cacheKey = "products_search_{$searchKey}_from_{$from}_to_{$to}_category_{$categoryId}_page_{$page}_is_pagination_" . $is_pagination;


        $cacheDuration = 60;
        return Cache::remember($cacheKey, $cacheDuration, function () use ($searchKey, $from, $to, $categoryId) {

            if (request('is_pagination')) {
                list($items, $pagination) = parent::paginate($this->product_repo, false);
            } else {
                $items = parent::list($this->product_repo, false);
                $pagination = null;
            }

            $items->load(['category']);
            return $this->ok('products list',FrontProductResource::collection($items),$pagination);
        });




    }



    public function show($id)
    {


        $product = $this->product_repo->get($id);

        $product = FrontProductResource::make($product);
        return $this->ok('product display',$product);
    }


}
