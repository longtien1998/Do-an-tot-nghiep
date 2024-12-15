<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index($user_id){
        // Fetch all payments made by the user
        $payments = Payment::where('users_id', '=', $user_id)->get();
        return response()->json($payments);
    }
}
