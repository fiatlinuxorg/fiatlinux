<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Create User
     * @param Request $request
     * @return User
     */

    public function createUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required'
            ]);

            if ($validateUser->fails()) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => $validateUser->errors()
                    ],
                    401
                );
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            return response()->json(
                [
                    'status' => true,
                    'message' => 'User created successfully',
                    'token' => $user->createToken('token')->plainTextToken,
                ],
                200
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $e->getMessage()
                ],
                500
            );
        }
    }

    /**
     * Login User
     * @param Request $request
     * @return User
     */

    public function loginUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if ($validateUser->fails()) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => $validateUser->errors()
                    ],
                    401
                );
            }

            if (!Auth::attempt($request->only('email', 'password'))) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'Invalid credentials'
                    ],
                    401
                );
            }

            $user = User::where('email', $request->email)->first();

            return response()->json(
                [
                    'status' => true,
                    'message' => 'User logged in successfully',
                    'token' => $user->createToken('token')->plainTextToken,
                    'user' => $user
                ],
                200
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $e->getMessage()
                ],
                500
            );
        }
    }

    /**
     * Logout User
     * @param Request $request
     * @return User
     */

    public function logoutUser(Request $request)
    {
        try {
            $request->user()->tokens()->delete();

            return response()->json(
                [
                    'status' => true,
                    'message' => 'User logged out successfully'
                ],
                200
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $e->getMessage()
                ],
                500
            );
        }
    }

    public function updateUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email',
            ]);

            if ($validateUser->fails()) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => $validateUser->errors()
                    ],
                    401
                );
            }

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'User not found'
                    ],
                    404
                );
            }

            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();

            return response()->json(
                [
                    'status' => true,
                    'message' => 'User updated successfully',
                    'user' => $user
                ],
                200
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $e->getMessage()
                ],
                500
            );
        }
    }
}
