<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role_detail;
use Flasher\Prime\FlasherInterface;
use Illuminate\Support\Facades\Log;

class Role_detailController extends Controller
{
    public function index(Request $request)
    {
        $perPage = 10;
        $filterRole = false;
        if ($request->isMethod('post')) {
            $perPage = $request->input('indexPage');
            $filterRole = $request->input('filterRole');
            // dd($request->all());
        }
        $roles = Role_detail::selectAll($perPage, $filterRole);

        return view('admin.users.role_detail', compact('roles'));
    }

    public function update(Request $request, $id , FlasherInterface $flasher)
    {
        // dd($request->all(), $id);
        try{

            $role = Role_detail::findOrFail($id);
            $role->{$request->role_column} = $request->checked ? 1 : 0;
            $role->save();
            // session()->flash('success', 'Cập nhật thành công!');
            return response()->json([
                'data' => $request->all(),
                'status' => true,
                'success' => true,
                'message' => 'Cập nhật trạng thái phân quyền thành công'
            ], 200);
        } catch(\Exception $e) {
            // session()->flash('error', 'Có lỗi xảy ra!');
            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => 'Có lỗi xảy ra khi cập nhật trạng thái phân quyền'
            ], 500);
        }
    }
}
