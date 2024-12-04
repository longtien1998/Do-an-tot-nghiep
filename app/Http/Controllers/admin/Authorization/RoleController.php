<?php

namespace App\Http\Controllers\Admin\Authorization;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;



class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = 10;
        $filterCreateStart = false;
        $filterCreateEnd = false;
        if ($request->isMethod('post')) {
            $perPage = $request->indexPage;
            $filterCreateStart = $request->input('filterCreateStart');
            $filterCreateEnd = $request->input('filterCreateEnd');
        }
        $query = Role::with('permissions');
        if ($filterCreateStart) {
            $query->where('created_at', '>=', $filterCreateStart);
        }

        if ($filterCreateEnd) {
            $query->where('created_at', '<=', $filterCreateEnd);
        }
        $roles = $query->paginate($perPage);
        return view('admin.authorization.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $modules = Permission::with(['module'])->select('permissions.module_id')->get();
        $permissions = Permission::all();
        $role = Role::all();
        $existingRoleTypes = Role::pluck('role_type')->toArray();
        $allRoleTypes = range(0, 20);
        return view('admin.authorization.roles.create', compact('role', 'modules', 'permissions','existingRoleTypes', 'allRoleTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|max:20|unique:roles,name',
            'role_type' =>'required|integer|min:0|max:20|unique:roles,role_type',
            'color' =>'required',
        ], [
            'name.required' => 'Tên vai trò không được để trống',
            'name.unique' => 'Tên vai trò đã tồn tại',
            'name.max' => 'Tên vai trò tối đa 20 ký tự',
            'role_type.required' => 'Loại vai trò không được để trống',
            'role_type.integer' => 'Loại vai trò phải là số nguyên',
            'role_type.min' => 'Loại vai trò từ 0 đến 20',
            'role_type.max' => 'Loại vai trò tối đa 20',
            'role_type.unique' => 'Loại vai trò đã tồn tại',
            'color.required' => 'Màu sắc không được để trống',

        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }
        try {
            $role = Role::create([
                'name' => $request->name,
                'role_type' => $request->role_type,
                'color' => $request->color,
            ]);
            $role->syncPermissions($request->permissions);
            return redirect()->route('roles.index')->with('success', 'Vai trò  đã được tạo!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Đã xảy ra lỗi khi tạo vai trò')->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $modules = Module::all();
        $permissions = Permission::all();
        $existingRoleTypes = Role::pluck('role_type')->toArray();
        $allRoleTypes = range(0, 20);
        return view('admin.authorization.roles.edit', compact('role', 'modules', 'permissions', 'existingRoleTypes', 'allRoleTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|max:20|unique:roles,name,' . $role->id,
            'role_type' =>'required|integer|min:0|max:20|unique:roles,role_type,'.$role->id,
            'color' => 'required',
        ], [
            'name.required' => 'Tên vai trò không được để trống',
            'name.unique' => 'Tên vai trò đã tồn tại',
            'name.max' => 'Tên vai trò tối đa 20 ký tự',
            'role_type.required' => 'Loại vai trò không được để trống',
            'role_type.integer' => 'Loại vai trò phải là một số',
            'role_type.min' => 'Loại vai trò tối thiểu là 0',
            'role_type.max' => 'Loại vai trò tối đa là 20',
            'role_type.unique' => 'Loại vai trò đã tồn tại',
            'color.required' => 'Màu sắc không được để trống',

        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }
        try {
            $role->update([
                'name' => $request->name,
                'role_type' => $request->role_type,
                'color' => $request->color,
            ]);
            $permissions = $request->input('permissions', []);
            $role->syncPermissions($permissions);

            return redirect()->route('roles.index')->with('success', 'Vai trò đã được cập nhật thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Đã xảy ra lỗi khi cập nhật vai trò')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        try {
            $role->delete();
            return redirect()->route('roles.index')->with('success', 'Vai trò đã được xóa thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Đã xảy ra lỗi khi xóa vai trò');
        }
    }
    public function delete_list(Request $request)
    {
        // dd($request->delete_list);
        $deletelist = json_decode($request->delete_list, true);
        if (is_array($deletelist)) {
            try {
                foreach ($deletelist as $list) {
                    $song = Role::findById($list);
                    $song->delete();
                }
                return redirect()->route('roles.index')->with('success', 'Vai trò đã được xóa thành công!');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa vai trò đã thất bại!');
            }
        } else {
            return redirect()->back()->with('error', 'Xóa vai trò đã thất bại!');
        }
    }
    public function search(Request $request)
    {
        $query = Role::query();
        $search = $request->search;
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }
        $roles = $query->paginate(10);
        return view('admin.authorization.roles.index', compact('roles'));
    }
}
