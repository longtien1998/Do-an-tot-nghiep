<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Users;
use App\Http\Requests\UsersRequest;
use App\Models\User;

class UsersController extends Controller
{
    public function list_users(){
        $users = User::all();
        return view('admin.users.list-users', compact('users'));
    }
    public function add_users(){
        return view('admin.users.add-users');
    }
    public function storeAddUser(UsersRequest $request){
        $users = new User();
        $users->name = $request->name;
        $users->email = $request->email;
        $users->phone = $request->phone;
        $users->password = bcrypt($request->password);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $users->image = $filename;
            // $file->move(public_path('upload/image/users'), $filename);
        }
        $users->gerder = $request->gerder;
        $users->birthday = $request->birthday;
        if ($users->save()) {
            $file->move(public_path('upload/image/users'), $filename);
            toastr()->success('Thêm tài khoản thành công');
            return redirect('/list-users');
        } else {
            toastr()->error('Thêm tài khoản thất bại');
            return redirect()->back();
        }
    }
    public function update_users($id){
        $users = User::find($id);
        return view('admin.users.update-users', compact('users'));
    }
    public function storeUpdate(UsersRequest $request, $id){
        $users = User::find($id);
        $users->name = $request->name;
        $users->email = $request->email;
        $users->phone = $request->phone;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $users->image = $filename;
            $file->move(public_path('upload/image/users'), $filename);
        }
        $users->gerder = $request->gerder;
        $users->birthday = $request->birthday;
        if ($users->save()) {
            toastr()->success('Cập nhật tài khoản thành công');
            return redirect('/list-users');
        } else {
            toastr()->error('Cập nhật tài khoản thất bại');
            return redirect()->back();
        }
    }
    public function delete_users($id){
        $users = User::find($id);
        $users->delete();
        toastr()->success('Xóa tài khoản thành công');
        return redirect('/list-users');
    }
}
