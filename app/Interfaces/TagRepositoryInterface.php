<?php

namespace App\Interfaces;

interface TagRepositoryInterface
{
    public function getAllTags();

    public function getTag(int $id);

    public function createTag(array $data);

    public function updateTag(array $data, int $id);

    public function deleteTag(int $id);
}
