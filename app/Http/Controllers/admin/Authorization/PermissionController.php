<?php

namespace App\Http\Controllers\Admin\Authorization;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;


class PermissionController extends Controller
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
        $query = Permission::query();
        if ($filterCreateStart) {
            $query->where('created_at', '>=', $filterCreateStart);
        }

        if ($filterCreateEnd) {
            $query->where('created_at', '<=', $filterCreateEnd);
        }
        $permissions = $query ->paginate($perPage);

        return view('admin.authorization.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $modules = Module::all();
        return view('admin.authorization.permissions.create', compact('modules'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|unique:permissions,name',
            'alias' => 'required|unique:permissions,alias',
            'module' => 'required',
        ],[
            'name.required' => 'Bí danh quyền hạn không được để trống',
            'name.unique' => 'Bí danh quyền hạn đã tồn tại',
            'alias.required' => 'Tên quyền hạn không được để trống',
            'alias.unique' => 'Tên quyền hạn đã tồn tại',
            'module' => 'Bạn chưa chọn Module cho quyền',
        ]);

        if($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }
        try{
            Permission::create([
                'name' => $request->name,
                'alias' => $request->alias,
                'module_id' => $request->module
            ]);
            return redirect()->route('permissions.index')->with('success','Quyền hạn đã được tạo!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error','Đã xảy ra lỗi khi tạo quyền hạn')->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $permission = Permission::findById($id);
        $modules = Module::all();
        // dd($permission);
        return view('admin.authorization.permissions.edit', compact('permission','modules'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $validate = Validator::make($request->all(), [
            'name' => 'required|unique:permissions,name,' .$id,
            'alias' => 'required|unique:permissions,alias,' .$id,
            'module' => 'required',
        ],[
            'name.required' => 'Bí danh quyền hạn không được để trống',
            'name.unique' => 'Bí danh quyền hạn đã tồn tại',
            'alias.required' => 'Tên quyền hạn không được để trống',
            'alias.unique' => 'Tên quyền hạn đã tồn tại',
            'module' => 'Bạn chưa chọn Module cho quyền',
        ]);

        if($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }
        $permission = Permission::findById($id);
        if(!$permission) {
            return redirect()->back()->with('error','Quyền hạn không tồn tại');
        }
        try{
            $permission->update([
                'name' => $request->name,
                'alias' => $request->alias,
                'module' => $request->module
            ]);
            return redirect()->route('permissions.index')->with('success','Quyền hạn đã được cập nhật!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error','Đã xảy ra lỗi khi cập nhật quyền hạn')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $permission = Permission::findById($id);
        if(!$permission) {
            return redirect()->back()->with('error','Quyền hạn không tồn tại');
        }
        try{
            $permission->delete();
            return redirect()->route('permissions.index')->with('success','Quyền hạn đã được xóa!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error','Đã xảy ra lỗi khi xóa quyền hạn');
        }

    }

    public function delete_list(Request $request)
    {
        // dd($request->delete_list);
        $deletelist = json_decode($request->delete_list, true);
        if (is_array($deletelist)) {
            try {
                foreach ($deletelist as $list) {
                    $song = Permission::findById($list);
                    $song->delete();
                }
                return redirect()->route('permissions.index')->with('success', 'Quyền hạn đã được xóa thành công!');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa Quyền hạn đã thất bại!');
            }
        } else {
            return redirect()->back()->with('error', 'Xóa Quyền hạn đã thất bại!');
        }
    }

    public function search(Request $request)
    {
        $keyword = $request->search;
        $permissions = Permission::where('name', 'LIKE', '%' . $keyword . '%')
            ->orWhere('alias', 'LIKE', '%' . $keyword . '%')
            ->orwhereHas('module', function ($query) use ($keyword) {
                $query->where('name', 'LIKE', '%' . $keyword . '%')
                ->orWhere('slug', 'LIKE', '%' . $keyword . '%');
            })
            ->paginate(20);
        return view('admin.authorization.permissions.index', compact('permissions'));
    }
}
