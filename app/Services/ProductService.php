<?php

namespace App\Services;


use App\Repositories\ProductRepository;


use App\Resources\ProductResource;
use App\Resources\UserResource;
use App\Traits\ApiResponses;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;




class ProductService extends LaravelServiceClass
{
    use ApiResponses;
    private $product_repo;


    public function __construct(ProductRepository $product_repo)
    {
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

    public function store($request = null)
    {
        return    DB::transaction(function() use($request) {

            $validatedData = $request->validated();


            $product = $this->product_repo->create($validatedData);



            $product->load(['category']);

            return $this->ok('product created',ProductResource::make($product));
        });

    }

    public function show($id)
    {


        $product = $this->product_repo->get($id);

        $product = ProductResource::make($product);
        return $this->ok('product display',$product);
    }

    public function update($id, $request = null)
    {

        return    DB::transaction(function() use($request, $id) {

            $validatedData = $request->validated();


            $product = $this->product_repo->update($id, $validatedData);


            $product->load(['category']);

            return $this->ok('product updated',ProductResource::make($product));
        });
    }



    public function delete($id)
    {
        try {
            $this->product_repo->delete($id);
            return $this->ok('Product deleted successfully');
        } catch (ModelNotFoundException $exception) {
            Log::error($exception);
            return $this->error('Product not found', 404);
        } catch (\Exception $exception) {
            Log::error($exception);
            return $this->error('An unexpected error occurred', 500);
        }
    }


}
