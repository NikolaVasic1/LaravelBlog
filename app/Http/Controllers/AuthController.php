<?php

namespace App\Http\Controllers;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(Request $request)
    {
        try {
            $fields = $request->validate([
                'nickname' => 'required|min:3|max:255',
                'firstname' => 'required|min:3|max:255',
                'lastname' => 'required|min:3|max:255',
                'email' => 'required|email|max:255|unique:users,email',
                'password' => 'required|min:7|max:255',
                'is_admin' => 'required',
            ]);

            $user = $this->userRepository->createUser($fields);
            $token = $user->createToken('API-TOKEN')->plainTextToken;

            $response = [
                'user' => $user,
                'token' => $token
            ];

            return response()->json($response, 201);
        } catch (ValidationException $e) {
            return response()->json(["error" => $e->getMessage()], 400);
        } catch (\Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }

    }

    public function login(Request $request)
    {
        try {
            $fields = $request->validate([
                'email' => 'required|email|max:255',
                'password' => 'required|min:7|max:255',
            ]);

            $user = $this->userRepository->findByEmail($fields['email']);
            if (!$user || !Hash::check($fields['password'], $user->password)) {
                return response()->json([
                    'message' => "Invalid credentials."
                ], 401);
            }
            $token = $user->createToken('API-TOKEN')->plainTextToken;

            $response = [
                'user' => $user,
                'token' => $token
            ];

            return response()->json($response, 200);
        } catch (ValidationException $e) {
            return response()->json(["error" => $e->getMessage()], 400);
        } catch (\Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }

    }

    public function logout(Request $request)
    {
        try {
            if (!auth()->user()) {
                return response()->json(["error" => "You are not logged in."], 401);
            }

            auth()->user()->tokens()->delete();

            return response()->json(["message" => "Logged out"], 200);
        } catch (\Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }

    }
}
