<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Users;
use App\Http\Requests\UsersRequest;
class UsersController extends Controller
{
    public function list_users(){
        $users = Users::all();
        return view('admin.users.list-users', compact('users'));
    }
    public function update_users($id){
        $users = Users::find($id);
        return view('admin.users.update-users', compact('users'));
    }
    public function storeUpdate(UsersRequest $request, $id){
        $users = Users::find($id);
        $users->firstname = $request->firstname;
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
            return redirect('/list-users')->with('success', 'Cập nhật tài khoản thành công');
        } else {
            return redirect()->back()->with('error', 'Cập nhật tài khoản thất bại');
        }
    }
    public function delete_users($id){
        $users = Users::find($id);
        $users->delete();
        return redirect('/list-users')->with('success', 'Xoá tài khoản thành công');
    }
}
