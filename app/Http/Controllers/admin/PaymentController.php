<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\Validator;


class PaymentController extends Controller
{

    public function list(Request $request)
    {
        $filterMethod = $request->input('filterMethod', false);
        $filterStatus = $request->input('filterStatus', false);
        $filterCreateStart = $request->input('filterCreateStart', false);
        $filterCreateEnd = $request->input('filterCreateEnd', false);
        $query = Payment::query();

        if ($filterMethod) {
            $query->where('payment_method', $filterMethod);
        }
        if ($filterStatus) {
            $query->where('payment_status', $filterStatus);
        }
        if ($filterCreateStart) {
            $query->where('payment_date', '>=', $filterCreateStart);
        }

        if ($filterCreateEnd) {
            $query->where('payment_date', '<=', $filterCreateEnd);
        }

        $payments = $query->paginate(20);

        return view('admin.payment.list', compact('payments'));
    }
    public function update(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);
        $payment->payment_status = $request->input('payment_status');
        try {
            $payment->save();
            return redirect()->route('payment.list')->with('success', 'Cập nhật trạng thái thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Cập nhật trạng thái thất bại');
        }

    }
    public function search(Request $request)
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
            $payments = Payment::search_pay($query);
            // dd($payments);
            if ($payments->isEmpty()) {
                return redirect()->route('payment.list')->with('error', 'Không tìm thấy kết quả nào phù hợp với từ khóa. Nhập mã thanh toán, mô tả hoặc phương thức thanh toán');
            } else {
                toastr()->success('Tìm kiếm thông tin thanh toán thành công');
                return view('admin.payment.list', compact('payments'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Không tìm thấy bài hát nào phù hợp với từ khóa.');
        }
    }
}
