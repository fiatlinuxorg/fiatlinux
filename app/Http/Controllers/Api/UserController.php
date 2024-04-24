<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


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
            if ($request->pfp) {
                // Upload image: decode and save
                // Remove data:image/png;base64, from the image string
                $request->pfp = preg_replace('/^data:image\/\w+;base64,/', '', $request->pfp);
                $image = base64_decode($request->pfp);
                // Crop image to 300 in width
                $manager = new ImageManager(new Driver());

                $image = $manager->read($image);
                $calc_height = $image->height() * 300 / $image->width();
                $image = $image->resize(300, $calc_height)->crop(300, 300)->toWebp(70);
                $imageName = $request->name . time() . '.webp';
                // Save image
                Storage::disk('public')->put('user_avatars/' . $imageName, $image);
                $user->pfp = $imageName;
            } else {
                $user->pfp = 'default.jpg';
            }
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
