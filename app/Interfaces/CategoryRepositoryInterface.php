<?php

namespace App\Interfaces;

interface CategoryRepositoryInterface
{
    public function getAllCategories();

    public function getCategory(int $id);

    public function createCategory(array $data);

    public function updateCategory(array $data, int $id);

    public function deleteCategory(int $id);
}
