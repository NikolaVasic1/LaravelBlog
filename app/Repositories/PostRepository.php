<?php

namespace App\Repositories;

use App\Interfaces\PostRepositoryInterface;
use App\Models\Comment;
use App\Models\Post;

class PostRepository implements PostRepositoryInterface
{
    private $model;

    public function __construct(Post $post)
    {
        $this->model = $post;
    }

    public function getAllPosts()
    {
        return $this->model->all();
    }

    public function getPostById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function createPost(array $data)
    {
        return $this->model->create($data);
    }

    public function updatePost(array $data, int $id)
    {
        $post = $this->getPostById($id);
        $post->fill($data);
        $post->save();
        return $post;
    }

    public function deletePost($id)
    {
        $post = $this->getPostById($id);
        $post->delete();
    }


    public function getPostComments($id)
    {
        $post = $this->getPostById($id);
        return $post->comments;
    }
}
