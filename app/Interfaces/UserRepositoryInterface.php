<?php

namespace App\Interfaces;


use Illuminate\Http\Request;

interface UserRepositoryInterface
{
    public function getAllUsers();

    public function getUserById($id);

    public function createUser($validatedData);

    public function updateUser($validatedData, $id);

    public function findByEmail($email);

    public function getUserComments($id);

    public function deleteUser($id);
}
