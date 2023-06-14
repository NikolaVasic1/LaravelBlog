<?php

namespace App\Interfaces;

interface CommentRepositoryInterface
{
    public function getAllComments();

    public function getComment(int $id);

    public function createComment(array $data);

    public function updateComment(array $data, int $id);

    public function deleteComment(int $id);
}
