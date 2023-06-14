<?php

namespace App\Repositories;

use App\Interfaces\CommentRepositoryInterface;
use App\Models\Comment;

class CommentRepository implements CommentRepositoryInterface
{
    private $model;

    public function __construct(Comment $comment)
    {
        $this->model = $comment;
    }

    public function getAllComments()
    {
        return $this->model->all();
    }

    public function getComment($id)
    {
        return $this->model->findOrFail($id);
    }

    public function createComment(array $data)
    {
        return $this->model->create($data);
    }

    public function updateComment(array $data, int $id)
    {
        $comment = $this->getComment($id);
        $comment->fill($data);
        $comment->save();
        return $comment;
    }

    public function deleteComment($id)
    {
        $comment = $this->getComment($id);
        $comment->delete();
    }
}
