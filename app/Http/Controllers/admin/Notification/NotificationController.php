<?php

namespace App\Http\Controllers\admin\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index(){
        $notifications = Notification::orderBy('created', 'DESC')->get();
        return response()->json(['notifications'=>$notifications]);
    }

    public function count(){
        $notification = Notification::where('status',1)->count();
        $notifications = Notification::orderBy('created_at', 'DESC')->get();
        return response()->json([
            'count' => $notification,
            'notifications' => $notifications
        ]);
    }
}
