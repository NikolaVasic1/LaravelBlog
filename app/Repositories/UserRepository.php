<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;

class UserRepository implements UserRepositoryInterface
{
    private $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function getAllUsers()
    {

        return $this->model->all();
    }

    public function getUserById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function findByEmail($email)
    {
        return $this->model->where("email", $email)->first();
    }

    public function createUser($validatedData)
    {
        $user = new User;
        $user->nickname = $validatedData['nickname'];
        $user->firstname = $validatedData['firstname'];
        $user->lastname = $validatedData['lastname'];
        $user->email = $validatedData['email'];
        $user->password = bcrypt($validatedData['password']);
        $user->is_admin = $validatedData['is_admin'];
        $user->created_at = now();
        $user->save();

        return $user;
    }

    public function updateUser($validatedData, $id)
    {
        $user = $this->model->findOrFail($id);
        $user->nickname = $validatedData['nickname'] ?? $user->nickname;
        $user->firstname = $validatedData['firstname'] ?? $user->firstname;
        $user->lastname = $validatedData['lastname'] ?? $user->lastname;
        $user->email = $validatedData['email'] ?? $user->email;
        $user->password = isset($validatedData['password']) ? bcrypt($validatedData['password']) : $user->password;
        $user->is_admin = $validatedData['is_admin'] ?? $user->is_admin;
        $user->updated_at = now();

        $user->save();

        return $user;
    }

    public function deleteUser($id)
    {
        $user = $this->model->findOrFail($id);

        return $user->delete();
    }


    public function getUserComments($id)
    {
        $user = $this->getUserById($id);
        return $user->comments;
    }
}
