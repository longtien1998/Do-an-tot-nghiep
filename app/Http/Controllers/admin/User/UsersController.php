<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UsersRequest;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use App\Models\User;



class UsersController extends Controller
{
    public function list_users(Request $request)
    {
        $perPage = 10;
        $filterGenDer = false;
        $filterRole = false;
        $filterCreate = false;
        if ($request->isMethod('post')) {
            $filterGenDer = $request->input('filterGenDer');
            $filterRole = $request->input('filterRole');
            $filterCreate = $request->input('filterCreate');
            $perPage = $request->input('indexPage');
        }
        $users = User::selectUsers($perPage, $filterGenDer, $filterRole, $filterCreate);
        $roles = Role::all();
        return view('admin.users.list-users', compact('users', 'roles'));
    }

    public function add_users()
    {

        return view('admin.users.add-users');
    }


    public function storeAddUser(UsersRequest $request)
    {
        $users = new User();
        $users->name = $request->name;
        $users->email = $request->email;
        $users->phone = $request->phone;
        $users->password = bcrypt($request->password);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $userName = $request->name;
            $url_image = User::up_file_users($file, $userName);
        } else {
            $url_image = 'https://soundwave2.s3.us-east-2.amazonaws.com/singer-image/user.png';
        }
        $users->image = $url_image;
        $users->gender = $request->gender;
        $users->birthday = $request->birthday;
        if ($users->save()) {

            return redirect()->route('users.list')->with('success', 'Thêm tài khoản thành công');
        } else {
            return redirect()->back()->with('error', 'Thêm tài khoản thất bại');
        }
    }
    public function edit_users($id)
    {
        $users = User::find($id);

        return view('admin.users.update-users', compact('users'));
    }
    public function update_users(UsersRequest $request, $id)
    {
        $users = User::find($id);
        $users->name = $request->name;
        $users->email = $request->email;
        $users->phone = $request->phone;
        if ($request->expriry_day) {
            $users->expriry_day = $request->expriry_day;
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $userName = $request->name;
            $url_image = User::up_file_users($file, $userName);
        } else {
            $url_image = $users->image;
        }
        $users->image = $url_image;
        $users->gender = $request->gender;
        $users->birthday = $request->birthday;
        $users->users_type = $request->users_type;
        if ($users->save()) {

            return redirect()->route('users.list')->with('success', 'Cập nhật tài khoản thành công');
        } else {
            return redirect()->back()->with('error', 'Cập nhật tài khoản thất bại');
        }
    }
    public function updatePass(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'password' => 'required|min:8',
        ], [
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu cần ít nhất 8 ký tự',
        ]);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->errors())->withInput();
        }
        $users = User::find($id);
        if ($users) {
            $users->password = bcrypt($request->password);
            if ($users->save()) {
                return redirect()->route('users.list')->with('success', 'Cập nhật mật khẩu thành công');
            } else {
                return redirect()->back()->with('error', 'Cập nhật mật khẩu thất bại');
            }
        } else {
            return redirect()->back()->with('error', 'Không tìm thấy tài khoản');
        }
    }

    public function list_trash_users()

    {
        $users = User::onlyTrashed()->orderByDesc('id')->paginate(10);
        return view('admin.users.list-trash-users', compact('users'));
    }

    public function delete_users($id)
    {
        $users = User::find($id);
        try {
            if($users->email == "admin@gmail.com"){
                return redirect()->back()->with('error', 'Không thể xóa tài khoản này');
            } else {
                $users->delete();
                return redirect()->back()->with('success', 'Xóa tài khoản thành công');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa tài khoản thất bại.');
        }
    }

    public function delete_trash_users(Request $request)
    {
        // dd($request->delete_list);
        // Giải mã chuỗi JSON thành mảng
        $deleteList = json_decode($request->delete_list, true);
        if (is_array($deleteList)) {
            try {
                foreach ($deleteList as $delete) {
                    User::withTrashed()->where('id', $delete)->forceDelete();
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa tài khoản khỏi thùng rác thất bại.');
            }
            return redirect()->back()->with('success', 'Xóa tài khoản khỏi thùng rác thành công!');
        } else {
            return redirect()->back()->with('error', 'Xóa tài khoản khỏi thùng rác thất bại!');
        }
    }

    public function delete_list_users(Request $request)
    {
        $deletelist = json_decode($request->delete_list, true);
        if (is_array($deletelist)) {
            try {

                foreach ($deletelist as $list) {
                    $users = User::find($list);
                    if($users){
                        if($users->email == "admin@gmail.com"){
                            return redirect()->back()->with('error', 'Không thể xóa tài khoản có email admin@gmail.com');
                        }
                        $users->delete();
                    }

                }
                return redirect()->route('users.list')->with('success', 'Xoá tài khoản thành công!');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa tài khoản thất bại.');
            }
        } else {
            return redirect()->back()->with('error', 'Xoá tài khoản thất bại!');
        }
    }



    public function restore_trash_users(Request $request)
    {
        // dd($request->restore_list);
        // Giải mã chuỗi JSON thành mảng
        $restoreList = json_decode($request->restore_list, true);
        if (is_array($restoreList)) {
            try {
                foreach ($restoreList as $restore) {
                    User::withTrashed()->where('id', $restore)->restore();
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra. Khôi phục tài khoản khỏi thùng rác thất bại.');
            }
            return redirect()->back()->with('success', 'Khôi phục tài khoản khỏi thùng rác thành công!');
        } else {
            return redirect()->back()->with('error', 'Khôi phục tài khoản khỏi thùng rác thất bại!');
        }
    }


    public function restore_all_users()
    {
        try {
            User::withTrashed()->restore();
            return redirect()->back()->with('success', 'Khôi phục tất cả tài khoản khỏi thùng rác thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Khôi phục tài khoản khỏi thùng rác thất bại.');
        }
    }


    public function delete_all_users()
    {
        try {
            User::withTrashed()->forceDelete();
            return redirect()->back()->with('success', 'Xóa tất cả tài khoản khỏi thùng rác thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa tài khoản khỏi thùng rác thất bại.');
        }
    }


    public function destroy_trash_users($id)
    {
        try {
            User::withTrashed()->where('id', $id)->forceDelete();
            return redirect()->route('users.trash.list')->with('success', 'Xóa tài khoản khỏi thùng rác thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa tài khoản khỏi thùng rác thất bại.');
        }
    }


    public function searchUser(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'search' => 'required|string',
        ], [
            'search.required' => 'Vui lòng nhập từ khóa tìm kiếm',
            'search.string' => 'Từ khóa tìm kiếm phải là chuỗi',
        ]);
        if ($validate->fails()) {
            return redirect()->back()->with('error', $validate);
        }
        try {
            $query = $request->search;
            $users = User::search_users($query);
            $roles = User::all();
            if ($users->isEmpty()) {
                return redirect()->route('users.list')->with('error', 'Không tìm thấy tài khoản nào phù hợp với từ khóa');
            } else {
                toastr()->success('Tìm tài khoản thành công');
                return view('admin.users.list-users', compact('users', 'roles'))->with('success', 'Tìm tài khoản thành công');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Không tìm thấy tài khoản nào phù hợp với từ khóa.');
        }
    }
    public function search_users_trash(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'search' => 'required|string',
        ], [
            'search.required' => 'Vui lòng nhập từ khóa tìm kiếm',
            'search.string' => 'Từ khóa tìm kiếm phải là chuỗi',
        ]);
        if ($validate->fails()) {
            return redirect()->back()->with('error', $validate);
        }
        try {
            $query = $request->search;
            $users = User::onlyTrashed()->where('name', 'LIKE', '%' . $query . '%')->paginate(15);
            if ($users->isEmpty()) {
                return redirect()->route('users.trash.list')->with('error', 'Không tìm thấy tài khoản nào phù hợp với từ khóa');
            } else {
                toastr()->success('Tìm tài khoản thành công');
                return view('admin.users.list-trash-users', compact('users'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Không tìm thấy tài khoản nào phù hợp với từ khóa.');
        }
    }
    public function show_user($id)
    {
        $users = User::show($id);
        // dd($users->role);
        return view('admin.users.show-users', compact('users',));
    }
}
