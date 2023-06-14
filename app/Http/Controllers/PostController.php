<?php

namespace App\Http\Controllers;

use App\Events\PostCreated;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Interfaces\PostRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Throwable;

class PostController extends Controller
{
    private $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * Get all posts
     *
     * @response 500 [{"error":"Failed to retrieve posts"}]
     * @return JsonResponse
     */
    public function getPosts()
    {
        try {
//            $posts = $this->postRepository->getAllPosts();
            return response()->json(PostResource::collection($this->postRepository->getAllPosts()), 200);
        } catch (Throwable $e) {
            return response()->json(['error' => 'Failed to retrieve posts'], 500);
        }
    }

    /**
     * Get single post
     *
     * @urlParam id int required The id of the post. Example: 9
     * @response 404 [{"error":"Post not found"}]
     * @response 500 [{"error":"Failed to retrieve post"}]
     * @return JsonResponse
     */
    public function getPost($id)
    {
        try {
            return response()->json(new PostResource($this->postRepository->getPostById($id)), 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Post not found'], 404);
        } catch (Throwable $e) {
            return response()->json(['error' => 'Failed to retrieve post'], 500);
        }
    }

    /**
     * Create post
     *
     * @bodyParam user_id int required The id of the post. Example: 2
     * @bodyParam title string required The title of the post. Example: Post title
     * @bodyParam content string required The content of the post. Example: Example content of one post
     * @bodyParam status string required The status of the post. Example: approved
     *
     * @response 422 [{"error":"Validation failed"}]
     * @response 500 [{"error":"Failed to create post"}]
     * @return JsonResponse
     */
    public function createPost(CreatePostRequest $request)
    {
        try {
            $validateData = $request->validated();
            $post = $this->postRepository->createPost($validateData);
            event(new PostCreated($post));
            return response()->json(new PostResource($post), 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Validation failed'], 422);
        } catch (Throwable $e) {
            return response()->json(['error' => 'Failed to retrieve post'], 500);
        }
    }

    /**
     * Update post
     *
     *
     * @urlParam id int required The id of the post. Example: 9
     * @bodyParam user_id int The id of the post. Example: 2
     * @bodyParam title string The title of the post. Example: Post title
     * @bodyParam content string The content of the post. Example: Example content of one post
     * @bodyParam status string The status of the post. Example: approved
     *
     * @response 404 [{"error":"Post not found"}]
     * @response 422 [{"error":"Validation failed"}]
     * @response 500 [{"error":"Failed to update post"}]
     * @return JsonResponse
     */
    public function updatePost(UpdatePostRequest $request, $id)
    {
        try {
            $validateData = $request->validated();
            return response()->json(new PostResource($this->postRepository->updatePost($validateData, $id)), 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Post not found'], 404);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Validation failed'], 422);
        } catch (Throwable $e) {
            return response()->json(['error' => 'Failed to retrieve post'], 500);
        }
    }

    /**
     * Delete post
     *
     * @urlParam id int required The id of the post. Example: 9
     * @response 404 [{"error":"Post not found"}]
     * @response 500 [{"error":"Failed to update post"}]
     * @return JsonResponse
     */
    public function deletePost($id)
    {
        try {
            $post = $this->postRepository->getPostById($id);
            $this->postRepository->deletePost($post->id);
            return response()->json(['data' => 'Post deleted successfully'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Post not found'], 404);
        } catch (Throwable $e) {
            return response()->json(['error' => 'Failed to retrieve post'], 500);
        }
    }

    public function getPostComments($id)
    {
        try {
            $comments = $this->postRepository->getPostComments($id);
            if ($comments->isEmpty()) {
                return response()->json(['data' => "The post has no comments."], 200);
            }
            return response()->json(['data' => $comments], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Comments not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve comments'], 500);
        }
    }
}
