<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Categories;
use App\Models\Comment;
use App\Models\Singer;

class SingerController extends Controller
{
    // Hiển thị danh sách ca sĩ
    public function index(Request $request)
    {
        $perPage = $request->input('indexPage', 10);
        $filterGenDer = $request->input('filterGenDer', false);
        $filterCreateStart = $request->input('filterCreateStart', false);
        $filterCreateEnd = $request->input('filterCreateEnd', false);
        $query = Singer::query();

        if ($filterGenDer) {
            $query->where('singer_gender', $filterGenDer);
        }

        if ($filterCreateStart) {
            $query->where('created_at', '>=', $filterCreateStart);
        }

        if ($filterCreateEnd) {
            $query->where('created_at', '<=', $filterCreateEnd);
        }

        $singers = $query->orderByDesc('id')->paginate($perPage);

        return view('admin.singer.list-singer', compact('singers'));
    }

    // Hiển thị form thêm ca sĩ mới
    public function create()
    {
        return view('admin.singer.add-singer');
    }

    // Lưu ca sĩ mới
    public function store(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'singer_name' => 'required|string|max:255|unique:singers,singer_name',
            'singer_birth_date' => 'required|date',
            'singer_gender' => 'required|string|max:255',
            'singer_biography' => 'nullable|string',
            'singer_country' => 'required|string|max:255',
            'singer_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'singer_background' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'singer_name.required' => 'Tên ca sĩ không được để trống',
            'singer_name.string' => 'Tên ca sĩ phải là chuỗi',
            'singer_name.max' => 'Tên ca sĩ không được dài quá 255 ký tự',
            'singer_name.unique' => 'Tên ca sĩ đã tồn tại',
            'singer_birth_date.required' => 'Ngày sinh không được để trống',
            'singer_birth_date.date' => 'Ngày sinh phải đúng định dạng ngày tháng',
            'singer_gender.required' => 'Giới tính không được để trống',
            'singer_gender.string' => 'Giới tính phải là chuỗi',
            'singer_biography.nullable' => 'Mô tả ca sĩ không được để trống',
            'singer_biography.string' => 'Mô tả ca sĩ phải là chuỗi',
            'singer_country.required' => 'Quê quán không được để trống',
            'singer_country.string' => 'Quê quán phải là chuỗi',
            'singer_image.image' => 'Hình đại diện phải là hình ảnh',
            'singer_image.mimes' => 'Hình đại diện chỉ cho phép định dạng JPEG, PNG, JPG',
            'singer_image.max' => 'Hình đại diện không quá 2MB',
            'singer_background.image' => 'Hình nền phải là hình ảnh',
            'singer_background.mimes' => 'Hình nền chỉ cho phép định dạng JPEG, PNG, JPG',
            'singer_background.max' => 'Hình nền không quá 2MB',
        ]);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->errors())->withInput();
        }

        $singer = new Singer();
        $singer->singer_name = $request->singer_name;
        $singer->singer_birth_date = $request->singer_birth_date;
        $singer->singer_gender = $request->singer_gender;
        $singer->singer_biography = $request->singer_biography;
        $singer->singer_country = $request->singer_country;

        if ($request->hasFile('singer_image')) {
            $file = $request->file('singer_image');
            $name = $request->singer_name;
            $singer->singer_image = Singer::up_image($file, $name);
        } else {
            $singer->singer_image = '';
        }
        if ($request->hasFile('singer_background')) {
            $file = $request->file('singer_background');
            $name = $request->singer_name;
            $singer->singer_background = Singer::up_image($file, $name);
        } else {
            $singer->singer_background = '';
        }

        if ($singer->save()) {
            return redirect()->route('singer.index')->with('success', 'Thêm ca sĩ thành công!');
        }

        return redirect()->back()->with('error', 'Thêm ca sĩ thất bại!');
    }

    // Hiển thị form cập nhật ca sĩ
    public function edit($id)
    {
        $singer = Singer::findOrFail($id);
        return view('admin.singer.edit', compact('singer'));
    }

    // Lưu thông tin ca sĩ sau khi cập nhật
    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'singer_name' => 'required|string|max:255|unique:singers,singer_name,' . $id,
            'singer_birth_date' => 'required|date',
            'singer_gender' => 'required|string|max:255',
            'singer_biography' => 'nullable|string',
            'singer_country' => 'required|string|max:255',
        ], [
            'singer_name.required' => 'Tên ca sĩ không được để trống',
            'singer_name.string' => 'Tên ca sĩ phải là chuỗi',
            'singer_name.max' => 'Tên ca sĩ không được dài quá 255 ký tự',
            'singer_name.unique' => 'Tên ca sĩ đã tồn tại',
            'singer_birth_date.required' => 'Ngày sinh không được để trống',
            'singer_birth_date.date' => 'Ngày sinh phải đúng định dạng ngày tháng',
            'singer_gender.required' => 'Giới tính không được để trống',
            'singer_gender.string' => 'Giới tính phải là chuỗi',
            'singer_biography.nullable' => 'Mô tả ca sĩ không được để trống',
            'singer_biography.string' => 'Mô tả ca sĩ phải là chuỗi',
            'singer_country.required' => 'Quê quán không được để trống',
            'singer_country.string' => 'Quê quán phải là chuỗi',
        ]);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->errors())->withInput();
        }

        $singer = Singer::findOrFail($id);
        $singer->singer_name = $request->singer_name;
        $singer->singer_birth_date = $request->singer_birth_date;
        $singer->singer_gender = $request->singer_gender;
        $singer->singer_biography = $request->singer_biography;
        $singer->singer_country = $request->singer_country;

        if ($request->hasFile('singer_image')) {
            $file = $request->file('singer_image');
            $name = $request->singer_name;
            $singer->singer_image = Singer::up_image($file, $name);
        }
        if ($request->hasFile('singer_background')) {
            $file = $request->file('singer_background');
            $name = $request->singer_name;
            $singer->singer_background = Singer::up_image($file, $name);
        }

        if ($singer->save()) {
            return redirect()->route('singer.index')->with('success', 'Cập nhật ca sĩ thành công!');
        }

        return redirect()->back()->with('error', 'Cập nhật ca sĩ thất bại!');
    }

    // Xóa ca sĩ (đưa vào thùng rác)
    public function delete($id)
    {
        try {
            Singer::findOrFail($id)->delete();
            return redirect()->route('singer.index')->with('success', 'Xóa ca sĩ thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Xóa ca sĩ thất bại!');
        }
    }


    public function delete_list(Request $request)
    {
        // dd($request->delete_list);
        $deletelist = json_decode($request->delete_list, true);
        if (is_array($deletelist)) {
            try {
                foreach ($deletelist as $list) {
                    $song = Singer::find($list);
                    $song->delete();
                }
                return redirect()->route('singer.index')->with('success', 'Xóa ca sĩ thành công');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa ca sĩ thất bại.');
            }
        } else {
            return redirect()->back()->with('error', 'Xoá ca sĩ thất bại!');
        }
    }

    public function search(Request $request)
    {
        $query = $request->search;
        $singers = Singer::search($query);
        // dd($singers);
        return view('admin.singer.list-singer', compact('singers'));
    }

    // Hiển thị danh sách ca sĩ trong thùng rác
    public function trash(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $filterCreateStart = $request->input('filterCreateStart', false);
        $filterCreateEnd = $request->input('filterCreateEnd', false);

        $query = Singer::onlyTrashed();

        if ($filterCreateStart) {
            $query->where('deleted_at', '>=', $filterCreateStart);
        }

        if ($filterCreateEnd) {
            $query->where('deleted_at', '<=', $filterCreateEnd);
        }

        $trashs = $query->orderByDesc('id')->paginate($perPage);

        return view('admin.singer.trash.index', compact('trashs'));
    }




    public function search_trash_singer(Request $request)
    {
        $query = $request->search;
        $trashs = Singer::search_trash_singer($query);
        return view('admin.singer.trash', compact('trashs'));
    }

    public function restore_singer($id)
    {
        $trash = Singer::withTrashed()->find($id);
        $trash->restore();
        return redirect()->route('singer.trash.index')->with('success', 'Khôi phục ca sĩ thành công');
    }

    public function restore_list_singer(Request $request)
    {
        $restorelist = json_decode($request->restore_list, true);
        if (is_array($restorelist)) {
            foreach ($restorelist as $restore) {
                $trash = Singer::withTrashed()->find($restore);
                $trash->restore();
            }
            return redirect()->route('singer.trash.index')->with('success', 'Khôi phục tất cả ca sĩ thành công');
        } else {
            return redirect()->back()->with('error', 'Khôi phục tất cả ca sĩ thất bại!');
        }
    }

    public function destroy_singer($id)
    {
        $trash = Singer::withTrashed()->find($id);
        $trash->forceDelete();
        return redirect()->route('singer.trash.index')->with('success', 'Xóa vĩnh viễn ca sĩ thành công');
    }

    public function restore_all_singer()
    {
        Singer::onlyTrashed()->restore();
        return redirect()->route('singer.trash.index')->with('success', 'Khôi phục tất cả ca sĩ thành công');
    }

    public function destroy_list_singer(Request $request)
    {
        $deletelist = json_decode($request->delete_list, true);
        if (is_array($deletelist)) {
            foreach ($deletelist as $list) {
                $trash = Singer::withTrashed()->find($list);
                $trash->forceDelete();
            }
            return redirect()->route('singer.trash.index')->with('success', 'Xóa vĩnh viễn tất cả ca sĩ thành công');
        } else {
            return redirect()->back()->with('error', 'Xoá tất cả ca sĩ thất bại!');
        }
    }
}
