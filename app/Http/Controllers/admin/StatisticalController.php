<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SongStatistical;
use App\Models\Payments;

class StatisticalController extends Controller
{

    public function payment()
    {
        $dataPay = Payments::paginate(20);
        return view('admin.statistical.payment', compact('dataPay'));
    }
   
    public function delete_payment($id)
    {
        try {
            $record = Payments::find($id);
            if ($record) {
                $record->forceDelete();
                return redirect()->route('statistical.payment')->with('success', 'Xoá bản ghi thành công!');
            } else {
                return redirect()->route('statistical.payment')->with('error', 'Không tìm thấy bản ghi!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa bản ghi thất bại.');
        }
    }
    public function delete_list_payment(Request $request)
    {
        $deleteList = json_decode($request->delete_list, true);
        if (is_array($deleteList)) {
            try {
                foreach ($deleteList as $id) {
                    $record = Payments::find($id);
                    if ($record) {
                        $record->forceDelete();
                    }
                }
                return redirect()->route('statistical.payment')->with('success', 'Xoá danh sách bản ghi thành công!');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa danh sách bản ghi thất bại.');
            }
        } else {
            return redirect()->back()->with('error', 'Danh sách bản ghi không hợp lệ!');
        }
    }
}
