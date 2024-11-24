<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
        $user = User::findOrFail($id);
        if (!$user) {
            return response()->json([
                'message' => 'Không tìm thấy tài khoản người dùng',
            ], 404);
        }
        $user->update($request->all());
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
