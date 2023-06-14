<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Interfaces\TagRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class TagController extends Controller
{
    private $tagRepository;

    public function __construct(TagRepositoryInterface $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function getAllTags()
    {
        try {
            $tags = $this->tagRepository->getAllTags();
            return response()->json(['data' => $tags], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => "Failed to retrieve tags"], 500);
        }
    }

    public function getTag($id)
    {
        try {
            $tag = $this->tagRepository->getTag($id);
            return response()->json(['data' => $tag], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Tag not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve tag'], 500);
        }
    }

    public function createTag(CreateTagRequest $request)
    {
        try {
            $validated = $request->validated();
            $tag = $this->tagRepository->createTag($validated);
            return response()->json(['data' => $tag]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create tag'], 500);
        }
    }

    public function updateTag(UpdateTagRequest $request, $id)
    {
        try {
            $validated = $request->validated();
            $tag = $this->tagRepository->updateTag($validated, $id);
            return response()->json(['data' => $tag]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Tag not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update tag'], 500);
        }
    }

    public function deleteTag($id)
    {
        try {
            $this->tagRepository->deleteTag($id);
            return response()->json(['data' => 'Tag is successfully deleted']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete tag'], 500);
        }
    }

}
