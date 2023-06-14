<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Interfaces\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategories()
    {
        try {
            $categories = $this->categoryRepository->getAllCategories();
            return response()->json(['data' => $categories], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => "Failed to retrieve categories"], 500);
        }
    }

    public function getCategory(int $id)
    {
        try {
            $category = $this->categoryRepository->getCategory($id);
            return response()->json(['data' => $category], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Category not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve category'], 500);
        }
    }

    public function createCategory(CreateCategoryRequest $request)
    {
        try {
            $validated = $request->validated();
            $category = $this->categoryRepository->createCategory($validated);
            return response()->json(['data' => $category], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve category'], 500);
        }
    }

    public function updateCategory(UpdateCategoryRequest $request, $id)
    {
        try {
            $validated = $request->validated();
            $category = $this->categoryRepository->updateCategory($validated, $id);
            return response()->json(['data' => $category], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve category'], 500);
        }
    }

    public function deleteCategory($id)
    {
        try {
            $this->categoryRepository->deleteCategory($id);
            return response()->json(['data' => "Category deleted successfully" ],200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Category not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete category'], 500);
        }
    }

}
