<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

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
        $user = User::find($id);
        if ($user == null) {
            return response()->json([
                'message' => 'Không tìm thấy tài khoản người dùng',
            ], 404);
        }
        $user->update($request->all());
        return response()->json([
            'message' => 'Cập nhật thành công',
            'token_type' => 'bearer',
            'user' => $user
        ]);
    }
    public function destroy($id) {}
    public function search(Request $request) {}
    public function newpass(Request $request)
    {
        $user = User::find($request->id);
        if ($user == null) {
            return response()->json([
                'message' => 'Không tìm thấy tài khoản người dùng',
            ], 404);
        }
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json([
            'message' => 'Đổi mật khẩu thành công',
            'token_type' => 'bearer',
            'user' => $user
        ]);
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
