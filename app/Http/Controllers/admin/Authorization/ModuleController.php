<?php

namespace App\Http\Controllers\Admin\Authorization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Module;
use Illuminate\Support\Facades\Validator;

class ModuleController extends Controller
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
        $modules = Module::index($perPage, $filterCreateStart, $filterCreateEnd);
        return view('admin.authorization.modules.index', compact('modules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $modules = Module::all();
        return view('admin.authorization.modules.create', compact('modules'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|max:100|unique:modules,name,',
            'slug' => 'required|max:100|unique:modules,slug,',
        ], [
            'name.required' => 'Tên module không được để trống.',
            'name.max' => 'Tên module quá dài',
            'name.unique' => 'Tên module đã có sẳn',
            'slug.required' => 'tên gọi khác không được để trống',
            'slug.max' => 'tên gọi khác quá dài',
            'slug.unique' => 'tên gọi khác đã có sẳn',
        ]);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }
        try {
            Module::create($request->all());
            return redirect()->back()->with('success', 'Thêm module thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Thêm module thất bại')->withInput();
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
    public function edit(string $id)
    {
        try {
            $module = Module::find($id);
            if (!$module) {
                return redirect()->route('modules.index')->with('error', 'Module không tồn tại');
            }
            return view('admin.authorization.modules.edit', compact('module'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|max:100|unique:modules,name,' . $id,
            'slug' => 'required|max:100|unique:modules,slug,' . $id,
        ], [
            'name.required' => 'Tên module không được để trống.',
            'name.max' => 'Tên module quá dài',
            'name.unique' => 'Tên module đã có sẳn',
            'slug.required' => 'tên gọi khác không được để trống',
            'slug.max' => 'tên gọi khác quá dài',
            'slug.unique' => 'tên gọi khác đã có sẳn',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }
        try {
            $module = Module::find($id);
            if (!$module) {
                return redirect()->route('modules.index')->with('error', 'Module không tồn tại');
            }
            $module->update($request->all());
            return redirect()->route('modules.index')->with('success', 'Cập nhật module thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Cập nhật module thất bại')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $module = Module::find($id);
            if (!$module) {
                return redirect()->route('modules.index')->with('error', 'Module không tồn tại');
            }
            $module->delete();
            return redirect()->route('modules.index')->with('success', 'Xóa module thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Xóa module thất bại');
        }
    }

    public function delete_list(Request $request)
    {
        // dd($request->delete_list);
        $deletelist = json_decode($request->delete_list, true);
        if (is_array($deletelist)) {
            try {
                foreach ($deletelist as $list) {
                    $song = Module::find($list);
                    $song->delete();
                }
                return redirect()->route('modules.index')->with('success', 'Xóa module thành công');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa module thất bại.');
            }
        } else {
            return redirect()->back()->with('error', 'Xoá module thất bại!');
        }
    }

    public function search(Request $request)
    {
        $keyword = $request->search;
        $modules = Module::where('name', 'LIKE', '%' . $keyword . '%')
            ->orWhere('slug', 'LIKE', '%' . $keyword . '%')
            ->paginate(20);
        return view('admin.authorization.modules.index', compact('modules'));
    }
}
