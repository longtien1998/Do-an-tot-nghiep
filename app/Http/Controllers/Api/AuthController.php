<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);
        if ($validator->fails()) return response()->json($validator->errors());
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['data' => $user, 'access_token' => $token, 'token_type' => 'Bearer',]);
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'email' => 'email|required',
                    'password' => 'required'
                ],
                [
                    'email.required' => 'Email không được để trống',
                    'email.email' => 'Email không đúng định dạng',
                    'password.required' => 'Mật khẩu không được để trống'

                ]
            );
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 401);
            }
            if (!$token = Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return response()->json(['error' => 'Sai email hoặc mật khẩu'], 401);
            }
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'message' => 'Đăng nhập thành công',
                'access_token' => $token,
                'token_type' => 'bearer',
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đăng nhập thất bại'], 401);
        }
    }
    public function logout()
    {
        Auth::user()->tokens->delete();
        return ['message' => 'Bạn đã thoát ứng dụng và token đã xóa'];
    }
}
