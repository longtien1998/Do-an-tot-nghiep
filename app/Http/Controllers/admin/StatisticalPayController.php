<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payments;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatisticalPayController extends Controller
{
    public function payment()
    {
        $dataPay = Payments::paginate(20);
        return view('admin.statistical.payment', compact('dataPay'));
    }
    public function getPay($date)
    {
        // dd($request->all());
        $startDate = Carbon::now()->subDays($date)->startOfDay(); // 20 ngày trước
        $endDate = Carbon::now()->endOfDay(); // Ngày hiện tại

        // Lấy dữ liệu từ cơ sở dữ liệu
        $data = DB::table('payments')
            ->select(
                DB::raw('DATE(payment_date) as date'),
                DB::raw('SUM(amount) as amount')
            )
            ->whereBetween('payment_date', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Chuẩn bị dữ liệu cho biểu đồ
        $labels = $data->pluck('date');
        $amount = $data->pluck('amount');
        // dd($labels);
        return response()->json([
            'labels' => $labels,
            'amount' => $amount,
        ]);
    }
    public function getPayByDate(Request $request)
    {
        $date = $request->input('date');

        $pays = DB::table('payments')
            ->join('users', 'payments.users_id', '=', 'users.id')
            ->select(
                'users.name as name',
                'payments.pay_id',
                'payments.description',
                DB::raw("DATE_FORMAT(payments.payment_date, '%Y-%m-%d') as payment_date"),
                'payments.payment_method',
                'payments.amount'
            )
            ->whereDate('payments.payment_date', $date)
            ->get();

        return response()->json([
            'pays' => $pays
        ]);
    }
}
