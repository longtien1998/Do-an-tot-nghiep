<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentVnpController extends Controller
{
    public function createVnpayUrl(Request $request)
    {
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        // $vnp_Returnurl = "http://127.0.0.1:8000/api/vnpay-return";
        // $vnp_Returnurl = "https://soundwave.io.vn/Pay";
        $vnp_Returnurl = "http://localhost:5173/PayNotification";

        $vnp_TmnCode = "X5Q306C0"; //Mã website tại VNPAY
        $vnp_HashSecret = "R04WJ0BG8LZTS97OTCCLTQ9PC6GRG6M2"; //Chuỗi bí mật

        $vnp_TxnRef = 'SW' . time(); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = 'SoundWave ' . $request->description . ' - ' . $request->month . ' tháng';
        $vnp_OrderType = 'Soundwave';
        $vnp_Amount = $request->amount * 100;
        $vnp_Locale = 'vn';

        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        //Add Params of 2.0.1 Version

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,

        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        $payment = Payment::create([
            'pay_id' => $vnp_TxnRef,
            'description' => $vnp_OrderInfo,
            'payment_date' => Carbon::now(),
            'payment_method' => $request->payment_method,
            'amount' => $request->amount,
            'users_id' => $request->user_id,
            'payment_status' => 'Đang thanh toán',
        ]);
        if ($payment) {
            $returnData = array(
                'success' => true,
                'code' => '00',
                'message' => 'success',
                'data' => $vnp_Url,
                'user_type' =>  $request->description,
                'month' => $request->month,


            );
        } else {
            $returnData = array(
                'success' => false,
                'code' => '01',
                'message' => 'Có lỗi xảy ra khi thanh toán',
                'data' => $vnp_Url,

            );
        }

        return response()->json($returnData, 200);
        // header('Location: ' . $vnp_Url);
    }

    public function vnpayReturn(Request $request)
    {
        $vnp_HashSecret = 'R04WJ0BG8LZTS97OTCCLTQ9PC6GRG6M2';
        $vnp_SecureHash = $_GET['vnp_SecureHash'];
        $inputData = array();
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }

        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        if ($secureHash == $vnp_SecureHash) {
            $payment = Payment::where('pay_id', $_GET['vnp_TxnRef'])->first();
            if ($_GET['vnp_ResponseCode'] == '00') {
                if ($payment) {
                    $payment->payment_status = 'Thành công';
                    $payment->save();
                    $user =  User::find($payment->users_id);
                    $user->users_type = $_GET['user_type'];
                    $user->expiry_date = $this->setdate((int)$_GET['month']);

                    $user->save();
                    return response()->json([
                        'success' => true,
                        'message' => 'Thanh toán thành công!',
                        'user' => $user
                    ]);
                } else {
                    return response()->json(['success' => false, 'message' => 'Đơn hàng không tồn tại!']);
                }
            } else {
                $payment->payment_status = 'Thất bại';
                $payment->save();
                return response()->json(['success' => false, 'message' => 'Thanh toán không thành công!']);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Thanh toán không thành công. Chữ ký không hợp lệ']);
        }
    }

    public function setdate($date)
    {

        $monthsToAdd = $date;

        if (!is_numeric($monthsToAdd) || $monthsToAdd < 0) {
            return null;
        }

        $expiryDate = Carbon::now()->addMonths($monthsToAdd)->format('Y-m-d');

        return $expiryDate;
    }
}
