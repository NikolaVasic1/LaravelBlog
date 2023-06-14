<?php

namespace App\Interfaces;

interface PostRepositoryInterface
{
    public function getAllPosts();

    public function getPostById($id);

    public function createPost(array $data);

    public function updatePost(array $data, int $id);

    public function getPostComments($id);

    public function deletePost($id);
}
