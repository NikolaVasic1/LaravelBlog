<?php

namespace App\Http\Controllers;

use App\Events\CommentCreated;
use App\Http\Requests\CreateCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Interfaces\CommentRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class CommentController extends Controller
{
    private $commentRepository;

    public function __construct(CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function getComments()
    {
        try {
            $comments = $this->commentRepository->getAllComments();
            return response()->json(['data' => $comments], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve comments'], 500);
        }
    }

    public function getComment($id)
    {
        try {
            $comment = $this->commentRepository->getComment($id);
            return response()->json(['data' => $comment], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Comment not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve comment'], 500);
        }
    }


    public function createComment(CreateCommentRequest $request)
    {
        try {
            $validateData = $request->validated();
            $comment = $this->commentRepository->createComment($validateData);
            event(new CommentCreated($comment));
            return response()->json(['data' => $comment], 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Validation failed'], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve comment'], 500);
        }
    }

    public function updateComment(UpdateCommentRequest $request, $id)
    {
        try {
            $validateData = $request->validated();
            $comment = $this->commentRepository->updateComment($validateData, $id);
            return response()->json(['data' => $comment], 200);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Validation failed'], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve comment'], 500);
        }
    }


    public function deleteComment($id)
    {
        try {
            $comment = $this->commentRepository->getComment($id);
            if($comment->user_id == auth()->id() || auth()->user()->is_admin){
                $this->commentRepository->deleteComment($id);
                return response()->json(['data' => 'Comment deleted successfully'], 200);
            }
            return response()->json(['data' => "You are not allowed to delete comment"], 403);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Comments not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete comment'], 500);
        }
    }

}
