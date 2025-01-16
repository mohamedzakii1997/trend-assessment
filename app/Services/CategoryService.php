<?php

namespace App\Services;





use App\Repositories\CategoryRepository;
use App\Resources\CategoryResource;
use App\Resources\ProductResource;
use App\Resources\UserResource;
use App\Traits\ApiResponses;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;




class CategoryService extends LaravelServiceClass
{
    use ApiResponses;
    private $category_repo;


    public function __construct(CategoryRepository $category_repo)
    {
        $this->category_repo = $category_repo;

    }

    public function index()
    {

        if (request('is_pagination')) {
            list($items, $pagination) = parent::paginate($this->category_repo, false);
        } else {
            $items = parent::list($this->category_repo, false);
            $pagination = null;
        }


        return $this->ok('category list',CategoryResource::collection($items),$pagination);

    }



}
