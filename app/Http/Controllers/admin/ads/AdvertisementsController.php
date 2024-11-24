<?php

namespace App\Http\Controllers\Admin\Ads;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Advertisements;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\AdvertisementsRequest;

class AdvertisementsController extends Controller
{


    public function list_advertisements()
    {
        $advertisements = Advertisements::selectAds();
        return view('admin.advertisements.list-advertisements', compact('advertisements'));
    }


    public function add_advertisements()
    {
        return view('admin.advertisements.add-advertisements');
    }


    public function storeAdvertisements(AdvertisementsRequest $request)
    {
        $data = [
            'ads_name' => $request->ads_name,
            'ads_description' => $request->ads_description
        ];


        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $adsName = $request->ads_name;
            $url_ads = Advertisements::up_file_ads($file, $adsName);
            $data['file_path'] = $url_ads;
        } else {
            $data['file_path'] = null;
        }
        if ($request->hasFile('image_path')) {
            $file = $request->file('image_path');
            $adsName = $request->ads_name;
            $url_image_ads = Advertisements::up_image_ads($file, $adsName);
            $data['image_path'] = $url_image_ads;
        } else {
            $data['image_path'] = null;
        }
        if (Advertisements::createAds($data)) {
            return redirect()->route('advertisements.list')->with('success', 'Thêm quảng cáo thành công');
        } else {
            return redirect()->back()->with('error', 'Thêm quảng cáo thất bại');
        }
    }




    public function edit_advertisements($id)
    {
        $ads = Advertisements::find($id);
        return view('admin.advertisements.update-advertisements', compact('ads'));
    }


    public function update_advertisements(Request $request, $id)
    {
        // Validate dữ liệu
        $request->validate([
            'ads_name' => 'required|string|max:255',
            'ads_description' => 'nullable|string',
            'file_path' => 'nullable|file|max:2048',
            'image_path' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'ads_name' => $request->ads_name,
            'ads_description' => $request->ads_description,
        ];

      
        if ($request->hasFile('file_path')) {
            $data['file_path'] = Advertisements::up_file_ads($request->file('file_path'), $request->ads_name);
        }


        if ($request->hasFile('image_path')) {
            $data['image_path'] = Advertisements::up_image_ads($request->file('image_path'), $request->ads_name);
        }

        // Gọi hàm updateAds
        Advertisements::updateAds($id, $data);

        return redirect()->route('advertisements.list')->with('success', 'Cập nhật quảng cáo thành công!');
    }
    public function delete($id)
    {
        try {
            Advertisements::find($id)->delete();
            return redirect()->route('advertisements.list')->with('success', 'Xoá quảng cáo thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa quảng cáo thất bại.');
        }
    }

    public function delete_trash_advertisements(Request $request)
    {
        // dd($request->delete_list);
        // Giải mã chuỗi JSON thành mảng
        $deleteList = json_decode($request->delete_list, true);
        if (is_array($deleteList)) {
            try {
                foreach ($deleteList as $delete) {
                    Advertisements::withTrashed()->where('id', $delete)->forceDelete();
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa quảng cáo khỏi thùng rác thất bại.');
            }
            return redirect()->back()->with('success', 'Xóa quảng cáo khỏi thùng rác thành công!');
        } else {
            return redirect()->back()->with('error', 'Xóa quảng cáo khỏi thùng rác thất bại!');
        }
    }

    public function delete_list_ads(Request $request)
    {
        // dd($request->delete_list);
        $deletelist = json_decode($request->delete_list, true);
        if (is_array($deletelist)) {
            try {
                foreach ($deletelist as $list) {
                    $advertisements = Advertisements::find($list);
                    $advertisements->deleted_at = now();
                    $advertisements->save();
                }
                return redirect()->route('advertisements.list')->with('success', 'Xoá quảng cáo thành công!');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa quảng cáo thất bại.');
            }
        } else {
            return redirect()->back()->with('error', 'Xoá quảng cáo thất bại!');
        }
    }


    public function list_trash_ads()

    {
        $advertisements = Advertisements::onlyTrashed()->paginate(10);
        return view('admin.advertisements.list-trash-advertisements', compact('advertisements'));
    }

    public function restore_trash_ads(Request $request)
    {
        // dd($request->restore_list);
        // Giải mã chuỗi JSON thành mảng
        $restoreList = json_decode($request->restore_list, true);
        if (is_array($restoreList)) {
            try {
                foreach ($restoreList as $restore) {
                    Advertisements::withTrashed()->where('id', $restore)->restore();
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra. Khôi phục quảng cáo khỏi thùng rác thất bại.');
            }
            return redirect()->back()->with('success', 'Khôi phục quảng cáo khỏi thùng rác thành công!');
        } else {
            return redirect()->back()->with('error', 'Khôi phục quảng cáo khỏi thùng rác thất bại!');
        }
    }


    public function restore_all_ads()
    {
        try {
            Advertisements::withTrashed()->restore();
            return redirect()->back()->with('success', 'Khôi phục tất cả quảng cáo khỏi thùng rác thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Khôi phục quảng cáo khỏi thùng rác thất bại.');
        }
    }

    public function delete_trash_ads(Request $request)
    {
        // dd($request->delete_list);
        // Giải mã chuỗi JSON thành mảng
        $deleteList = json_decode($request->delete_list, true);
        if (is_array($deleteList)) {
            try {
                foreach ($deleteList as $delete) {
                    Advertisements::withTrashed()->where('id', $delete)->forceDelete();
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa quảng cáo khỏi thùng rác thất bại.');
            }
            return redirect()->back()->with('success', 'Xóa quảng cáo khỏi thùng rác thành công!');
        } else {
            return redirect()->back()->with('error', 'Xóa quảng cáo khỏi thùng rác thất bại!');
        }
    }

    public function delete_all_ads()
    {
        try {
            Advertisements::withTrashed()->forceDelete();
            return redirect()->back()->with('success', 'Xóa tất cả quảng cáo khỏi thùng rác thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa quảng cáo khỏi thùng rác thất bại.');
        }
    }


    public function destroy_trash_ads($id)
    {
        try {
            Advertisements::withTrashed()->where('id', $id)->forceDelete();
            return redirect()->route('advertisements.trash.list')->with('success', 'Xóa quảng cáo khỏi thùng rác thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa quảng cáo khỏi thùng rác thất bại.');
        }
    }


    public function searchAds(Request $request)
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
            $advertisements = Advertisements::search_ads($query);
            if ($advertisements->isEmpty()) {
                return redirect()->route('advertisements.list')->with('error', 'Không tìm thấy bài hát nào phù hợp với từ khóa');
            } else {
                toastr()->success('Tìm quảng cáo thành công');
                return view('admin.advertisements.list-advertisements', compact('advertisements'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Không tìm thấy bài hát nào phù hợp với từ khóa.');
        }
    }
    public function search_ads_trash(Request $request)
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
            $advertisements = Advertisements::onlyTrashed()
                ->where('ads_name', 'LIKE', '%' . $query . '%')
                ->orWhere('ads_description', 'LIKE', '%' . $query . '%')
                ->get();
            if ($advertisements->isEmpty()) {
                return redirect()->route('list_trash_ads')->with('error', 'Không tìm thấy quảng cáo nào phù hợp với từ khóa');
            } else {
                toastr()->success('Tìm quảng cáo thành công');
                return view('admin.advertisements.list-trash-advertisements', compact('advertisements'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Không tìm thấy quảng cáo nào phù hợp với từ khóa.');
        }
    }
}
