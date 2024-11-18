<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Singer;
use App\Http\Requests\SingerRequest;


class SingerController extends Controller
{
    // public function list_singer(){
    //     return view('admin.singer.list-singer');
    // }
    // public function add_singer(){
    //     return view('admin.singer.add-singer');
    // }
    // public function update_singer(){
    //     return view('admin.singer.update-singer');
    // }
    // Hiển thị danh sách ca sĩ
    // public function list_singer(){
    //     $singer = Singer::all();
    //     return view('admin.singer.list-singer', compact('singer'));
    // }


    // Lưu thông tin ca sĩ mới
    public function list_singer(Request $request)
    {
        $perPage = 10;
        $filterGenDer = false;
        $filterRole = false;
        $filterCreate = false;
        if ($request->isMethod('post')) {
            $filterGenDer = $request->input('filterGenDer');
            $filterRole = $request->input('filterRole');
            $filterCreate = $request->input('filterCreate');
        }
        $users = singer::selectUsers($perPage, $filterGenDer, $filterRole, $filterCreate);
        return view('admin.users.list-singer', compact('singer'));
    }

    // Hiển thị form để thêm ca sĩ mới
    public function add_singer()
    {
        return view('admin.singer.add-singer');
    }


    // Hiển thị form để cập nhật thông tin ca sĩ
    public function update_singer($id)
    {
        $singer = Singer::find($id);
        return view('admin.singer.update-singer', compact('singer'));
    }

    // Lưu thông tin cập nhật ca sĩ
    public function storeUpdate(Request $request, $id)
    {
        $singer = Singer::find($id);
        $singer->singer_name = $request->singer_name;
        $singer->singer_birth_date = $request->singer_birth_date;
        $singer->singer_genre = $request->singer_genre;
        $singer->singer_biography = $request->singer_biography;
        $singer->singer_country = $request->singer_country;

        if ($request->hasFile('singer_image')) {
            $file = $request->file('singer_image');
            $filename = $file->getClientOriginalName();
            $singer->singer_image = $filename;
            $file->move(public_path('upload/image/singer'), $filename);
        }

        if ($singer->save()) {
            toastr()->success('Cập nhật ca sĩ thành công');
            return redirect('/list-singer');
        } else {
            toastr()->error('Cập nhật ca sĩ thất bại');
            return redirect()->back();
        }
    }

    // Xóa ca sĩ
    public function delete_singer($id)
    {
        $singer = Singer::find($id);
        $singer->delete();
        toastr()->success('Xóa ca sĩ thành công');
        return redirect('/list-singer');
    }
}
