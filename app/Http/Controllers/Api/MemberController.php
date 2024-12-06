<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    public function index()
    {
        $users = User::All();
        if ($users->isEmpty()) {
            return response()->json([
                'message' => 'No member found',
            ], 404);
        }
        return response()->json([
            'message' => ' susses member',
            'token_type' => 'bearer',
            'user' => $users
        ]);
    }
    public function create() {}
    public function store(Request $request) {}
    public function show($id)
    {
        $user = User::find($id);
        if ($user == null) {
            return response()->json([
                'message' => 'Không tìm thấy tài khoản người dùng',
            ], 404);
        }
        return response()->json([
            'message' => 'Tài khoản người dùng',
            'token_type' => 'bearer',
            'user' => $user
        ]);
    }
    public function edit($id) {}
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,'. $id,
            'birthday' => 'required',
            'gender'=> 'required',
            'phone' => 'required',
            'password' => 'required',
        ], [
            'name.required' => 'Tên không được để trống',
            'name.max' => 'Tên không được quá 255 ký tự',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại',
            'birthday.required' => 'Ngày sinh không được để trống',
            'gender.required' => 'Giới tính không được để trống',
            'phone.required' => 'Số điện thoại không được để trống',
            'password.required' => 'Mật khẩu không được để trống',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }

        $user = User::findOrFail($id);
        if (!$user) {
            return response()->json([
                'message' => 'Không tìm thấy tài khoản người dùng',
            ], 404);
        }
        $data = $request->all();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = bcrypt($request->password);
        $user->birthday = $request->birthday;
        $user->gender = $request->gender;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $userName = $user->name;
            $url_image = User::up_file_users($file, $userName);
            $data['image'] = $url_image;
        } else {
            $data['image'] = $user->image;
        }

        $user->update($data);
        return response()->json([
            'message' => 'Cập nhật thành công',
            'user' => $user
        ]);
    }
    public function destroy($id) {}
    public function search(Request $request) {}

    public function newpass(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($user == null) {
            return response()->json([
                'message' => 'Không tìm thấy tài khoản người dùng',
            ], 404);
        }
        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Mật khẩu hiện tại không chinh xác'], 404);
        }
        try{
            $user->update([
                'password' => bcrypt($request->new_password),
            ]);

            return response()->json([
                'message' => 'Đổi mật khẩu thành công',
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi'], 500);
        }
    }

    public function filter(Request $request) {}
    public function sort(Request $request) {}
    public function import(Request $request) {}
    public function export(Request $request) {}
    public function exportToPdf($id) {}
    public function exportToExcel($id) {}
    public function exportToCsv($id) {}
    public function exportToWord($id) {}
    public function exportToPptx($id) {}
    public function exportToJpg($id) {}
    public function exportToTiff($id) {}
    public function exportToGif($id) {}
    public function exportToBmp($id) {}

    public function exportToPng($id) {}
}
