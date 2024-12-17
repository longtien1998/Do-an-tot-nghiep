<?php

namespace App\Http\Controllers\Admin\Authorization;

use App\Http\Controllers\Controller;
use AWS\CRT\HTTP\Response;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthorizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = 10;
        if ($request->isMethod('post')) {
            $perPage = $request->indexPage;
        }
        $users = User::paginate($perPage);
        $roles = Role::all();
        return view('admin.authorization.authorization.index', compact('roles', 'users'));
    }

    public function update(Request $request, User $user)
    {

        // return response()->json([
        //     'success' => true,
        //     'user' => $user,
        //     'data' => $request->all(),
        //     'message' => 'Cập nhật vai trò thành công',
        // ]);
        $validate = Validator::make($request->all(), [
            'role' => 'nullable|exists:roles,id', // Vai trò có thể để trống hoặc phải tồn tại
        ], [
            'role.exists' => 'Vai trò không tồn tại', // Thông báo nếu vai trò không tồn tại
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validate->errors()->first(),
                'errors' => $validate->errors()
            ]);
        }
        try {

            if ($request->role) {
                // Cập nhật vai trò nếu người dùng chọn vai trò mới
                $user->syncRoles($request->role);
            } else {
                // Xóa tất cả vai trò nếu không chọn vai trò
                $user->syncRoles([]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật vai trò thành công',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Cập nhật vai trò thất bại',
            ]);
        }
    }
}
