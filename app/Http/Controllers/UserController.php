<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Requests\LoginRequest;
use App\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\JWTAuth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register', 'logout']]);
    }

    public function index(): \Illuminate\Database\Eloquent\Collection
    {
        return User::all();
    }

    public function login(LoginRequest $request, JWTAuth $jwtAuth): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');

        $token = auth()->attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = auth()->user();
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);

    }

    public function register(UserRequest $request): \Illuminate\Http\JsonResponse
    {
        $user = User::factory()->create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'is_admin' => 0,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'avatar' => $request->avatar,
            'phone_number' => $request->phone_number,
            'is_marketing' => $request->is_marketing,
            'last_login_at' => null
        ]);

        $token = auth()->login($user);
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function logout(Request $request, JWTAuth $jwtAuth): \Illuminate\Http\JsonResponse
    {
        try {
            $jwtAuth->invalidate($jwtAuth->getToken());
            return response()->json([
                "status" => "success",
                "message"=> "User successfully logged out."
            ]);
        } catch (JWTException $e) {
            return response()->json([
                "status" => "error",
                "message" => "Failed to logout, please try again."
            ], 500);
        }
    }

    public function update(UserRequest $request, JWTAuth $jwtAuth)
    {
        $jwtAuth->getToken();
        $user = $jwtAuth->toUser();

        if ($user) {
            $user->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'is_admin' => $request->is_admin,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'avatar' => $request->avatar,
                'phone_number' => $request->phone_number,
                'is_marketing' => $request->is_marketing,
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'OK',
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
            ], 401);
        }
    }

    public function destroy(JWTAuth $jwtAuth)
    {
        $token = $jwtAuth->getToken();

        if ($token) {
            $user = $jwtAuth->toUser();
            $user->delete();
            $jwtAuth->invalidate($token);
            return response()->json([
                'status' => 'success',
                'message' => 'OK',
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }
    }

    public function getOrders(JWTAuth $jwtAuth)
    {
        $jwtAuth->getToken();
        return $jwtAuth->toUser()->orders()->get();
    }
}
