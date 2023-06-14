<?php

namespace App\Repositories;

use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface
{
    private $model;

    public function __construct(Category $comment)
    {
        $this->model = $comment;
    }

    public function getAllCategories()
    {
        return $this->model->all();
    }

    public function getCategory(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function createCategory(array $data)
    {
        return $this->model->create($data);
    }

    public function updateCategory(array $data, int $id)
    {
        $category = $this->getCategory($id);
        $category->fill($data);
        $category->save();
        return $category;
    }

    public function deleteCategory(int $id)
    {
        $category = $this->getCategory($id);
        $category->delete();
    }
}
