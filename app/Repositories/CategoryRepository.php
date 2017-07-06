<?php

namespace App\Repositories;

use App\Models\Category\Category;
use App\Exceptions\GeneralException;

class CategoryRepository extends BaseRepository
{

    public $model, $query;
    public function __construct(Category $category)
    {
        $this->model = $category;
        $this->query = $this->model->query();
    }
}
