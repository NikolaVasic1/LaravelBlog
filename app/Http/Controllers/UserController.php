<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;


class UserController extends Controller
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        try {
            return response()->json([
                 UserResource::collection($this->userRepository->getAllUsers())
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            return response()->json([ new UserResource($this->userRepository->getUserById($id))
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function create(CreateUserRequest $request)
    {
        try {
            $validateData = $request->validated();
            return response()->json( new UserResource($this->userRepository->createUser($validateData)), 201);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => $e->getMessage()], 404);
        } catch (ValidationException $e) {
            return response()->json(["error" => $e->getMessage()], 422);
        } catch (\Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }

    }

    public function update(UpdateUserRequest $request, $id)
    {
        try {
            $validatedData = $request->validated();
            return response()->json(new UserResource($this->userRepository->updateUser($validatedData, $id)));
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => $e->getMessage()], 404);
        } catch (ValidationException $e) {
            return response()->json(["error" => $e->getMessage()], 422);
        } catch (\Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }

    }

    public function delete($id)
    {
        try {
            $this->userRepository->deleteUser($id);
            return response()->json(["success" => "User deleted"], 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => $e->getMessage()], 404);
        } catch (\Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function getUserComments($id)
    {
        try {
            $comments = $this->userRepository->getUserComments($id);
            if ($comments->isEmpty()) {
                return response()->json(['data' => "The user has no comments."], 200);
            }
            return response()->json(['data' => $comments], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Comments not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve comments'], 500);
        }
    }
}
