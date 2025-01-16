<?php
namespace App\Repositories;

use App\Models\Category;


use App\Repositories;

class CategoryRepository extends LaravelRepositoryClass
{
    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    public function paginate($per_page = 15, $conditions = [], $search_keys = null, $sort_key = 'id', $sort_order = 'asc', $lang = null)
    {
        $query = $this->filtering($search_keys);
        $query = $query->where($conditions);
        return parent::paginate($query, $per_page, $conditions, $sort_key, $sort_order);
    }

    public function all($conditions = [], $search_keys = null)
    {
        $query = $this->filtering($search_keys);

        return $query->where($conditions)->get();
    }

    private function filtering($search_keys)
    {
        $query = $this->model;


        if ($search_keys) {
        }


        return $query;
    }

}
