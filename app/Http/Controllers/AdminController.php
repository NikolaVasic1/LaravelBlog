<?php

namespace App\Http\Controllers;

use App\Interfaces\CommentRepositoryInterface;
use App\Interfaces\PostRepositoryInterface;
use App\Models\Comment;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private $commentRepository;
    private $postRepository;
    public function __construct(CommentRepositoryInterface $commentRepository, PostRepositoryInterface $postRepository)
    {
        $this->commentRepository = $commentRepository;
        $this->postRepository =$postRepository;
    }

    public function approveComment($id)
    {
        try {

            $data = ['is_approved' => 1];
            $comment = $this->commentRepository->updateComment($data, $id);
            return response()->json(["data" => $comment],200);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Comment not found"], 404);
        } catch (\Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function approvePost($id)
    {
        try {

            $data = ['published_at' => now()];
            $post = $this->postRepository->updatePost($data, $id);
            return response()->json(["data" => $post],200);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Post not found"], 404);
        } catch (\Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

}
