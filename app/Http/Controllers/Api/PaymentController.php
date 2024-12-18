<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function index($user_id){
        // Fetch all payments made by the user
        $payments = Payment::where('users_id', '=', $user_id)
        ->orderByDesc('id')
        ->get()
        ->map(function ($payment) {
            $payment->payment_date =  Carbon::parse($payment->payment_date)

            ->format('H:m d-m-Y');

            return $payment;
        });
        return response()->json($payments);
    }
}
