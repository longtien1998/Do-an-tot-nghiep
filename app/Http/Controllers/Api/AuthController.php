<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\PasswordReset;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtpMail;
use App\Models\User\RolesModel;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        // xác thực request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255,un',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8'

        ]);
        if ($validator->fails()) return response()->json($validator->errors());

        //check email
        $user = User::where('email', $request->email)->first();
        if ($user) return response()->json(['message' => 'Email đã tồn tại'], 400);

        // tạo tài khoản
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'email_verified_at' => now(),
                'password' => Hash::make($request->password),
                'gender' => $request->gender,
                'birthday' => $request->birthday,
                'image' => 'https://admin.soundwave.io.vn/upload/image/users/user.png',
                'remember_token' => Str::random(10),
                'users_type' => 'Basic',
            ]);

            // tạo token
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json(['data' => $user, 'access_token' => $token, 'token_type' => 'Bearer',], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đăng ký thất bại' . $e], 500);
        }
    }





    public function login(Request $request)
    {

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
        try {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'message' => 'Đăng nhập thành công',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đăng nhập thất bại'], 401);
        }
    }
    public function logout(Request $request)
    {
        // Auth::user()->tokens->delete();
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Đăng xuất thành công!'], 200);
    }
    // public function logout()
    // {
    //     Auth::user()->tokens->delete();
    //     return ['message' => 'Bạn đã thoát ứng dụng và token đã xóa'];
    // }
    public function refresh()
    {
        $token = Auth::user()->createToken('auth_token')->plainTextToken;
        return response()->json(['access_token' => $token, 'token_type' => 'Bearer']);
    }





    public function resetPassword(Request $request)
    {
        // xác thực request
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        $user = User::where('email', $request->email)->first();
        // check user
        if (!$user) {
            return response()->json(['message' => 'Email không tồn tại'], 404);
        }
        // Tạo mã OTP ngẫu nhiên (9 ký tự)
        $token = rand(100000, 999999);
        // Lưu OTP vào bảng password_resets (ghi đè nếu đã tồn tại)
        $resetpassword = PasswordReset::where('email', $request->email)->first();
        if (!$resetpassword) {
            PasswordReset::Create(
                [
                    'email' => $user->email,
                    'token' => Hash::make($token),
                    'created_at' => Carbon::now()
                ]
            );
        } else {
            PasswordReset::where('email', $request->email)->update([
                'token' => Hash::make($token),
                'created_at' => Carbon::now()
            ]);
        }

        try {
            // Gửi email với mã token
            Mail::to($user->email)->send(new SendOtpMail($token, $request->email));

            return response()->json([
                'message' => 'Mã OTP đã được gửi về email của bạn',
                'email' => $request->email
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gửi mã đặt lại mật khẩu thất bại' . $e], 500);
        }
    }



    public function checkOtp(Request $request)
    {
        // Validate dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'otp' => 'required',
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Lấy OTP từ cơ sở dữ liệu
        $passwordReset = PasswordReset::where('email', $request->email)->first();

        if (!$passwordReset || !Hash::check($request->otp, $passwordReset->token)) {
            return response()->json(['message' => 'Mã OTP không hợp lệ'], +400);
        }

        // Kiểm tra thời hạn của OTP (10 phút)
        if (Carbon::parse($passwordReset->created_at)->addMinutes(10)->isPast()) {
            return response()->json(['message' => 'Mã OTP đã hết hạn'], 400);
        }
        return response()->json(['message' => 'thành công'], 200);
    }

    public function newPassword(Request $request)
    {
        // Validate dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Đặt lại mật khẩu mới cho user
        try {
            $user = User::where('email', $request->email)->update([

                'password' => Hash::make($request->password),
                'updated_at' => Carbon::now(),
            ]);
            if (!$user) {
                return response()->json(['message' => 'Cập nhật mật khẩu thất bại'], 500);
            }
            // Xóa OTP sau khi sử dụng
            PasswordReset::where('email', $request->email)->delete();

            return response()->json(['message' => 'Mật khẩu đã được đặt lại thành công!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đặt lại mật khẩu thất bại' . $e], 500);
        }
    }
}
