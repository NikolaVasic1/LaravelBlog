<?php

namespace App\Repositories;

use App\Interfaces\TagRepositoryInterface;
use App\Models\Tag;

class TagRepository implements TagRepositoryInterface
{
    private $model;

    public function __construct(Tag $tag)
    {
        $this->model = $tag;
    }

    public function getAllTags()
    {
       return $this->model->all();
    }

    public function getTag(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function createTag(array $data)
    {
        return $this->model->create($data);
    }

    public function updateTag(array $data, int $id)
    {
       $tag = $this->getTag($id);
       $tag->fill($data);
       $tag->save();

       return $tag;
    }

    public function deleteTag(int $id)
    {
        $tag = $this->getTag($id);
        $tag->delete();
    }
}
