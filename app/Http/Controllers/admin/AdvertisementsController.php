<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Advertisements;
use App\Http\Requests\AdvertisementsRequest;

class AdvertisementsController extends Controller
{

    public function list_advertisements()
    {
        $advertisements = Advertisements::all();
        return view('admin.advertisements.list-advertisements', compact('advertisements'));
    }
    public function add_advertisements()
    {
        return view('admin.advertisements.add-advertisements');
    }
    public function storeAdvertisements(AdvertisementsRequest $request)
    {
        $ads = new Advertisements();
        $ads->ads_name = $request->ads_name;
        $ads->ads_description = $request->ads_description;
        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $filename = $file->getClientOriginalName();
            // $file->move(public_path('admin/upload/ads'), $filename);
            $ads->file_path = $filename;
        }
        if ($ads->save()) {
            $file->move(public_path('admin/upload/ads'), $filename);
            toastr()->success('Thêm quảng cáo thành công');
            return redirect('/list-advertisements');
        } else {
            return redirect()->back();
        }
    }
    public function update_advertisements($id)
    {
        $ads = Advertisements::find($id);
        return view('admin.advertisements.update-advertisements', compact('ads'));
    }
    public function storeUpdate(Request $request, $id)
    {
        $ads = Advertisements::find($id);
        $ads->ads_name = $request->ads_name;
        $ads->ads_description = $request->ads_description;
        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $filename = $file->getClientOriginalName();
            $ads->file_path = $filename;
            $file->move(public_path('admin/upload/ads'), $filename);
        }
        if ($ads->save()) {
            toastr()->success('Cập nhật quảng cáo thành công');
            return redirect('/list-advertisements');
        } else {
            toastr()->error('Cập nhật quảng cáo thất bại');
            return redirect()->back();
        }
    }
    public function delete_advertisements($id){
        $ads = Advertisements::find($id);
        $ads->delete();
        toastr()->success('Xóa quảng cáo thành công');
        return redirect('/list-advertisements');
    }
}
