<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendContactMail;


class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'topic' => 'required|string|max:255',
            'message' => 'required',
        ], [
            'username.required' => 'Tên không được để trống',
            'username.string' => 'Tên phải là chuỗi',
            'username.max' => 'Tên quá dài',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.max' => 'Email quá dài',
            'topic.required' => 'Chủ đề không được để trống',
            'topic.string' => 'Chủ đề phải là chuỗi',
            'topic.max' => 'Chủ đề quá dài',
            'message.required' => 'Nội dung không được để trống',

        ]);
        if ($validatedData->fails()) {
            return response()->json($validatedData->errors(), 422);
        }
        try {
            $contact = Contact::create([
                'username' => $request->username,
                'email' => $request->email,
                'topic' => $request->topic,
                'message' => $request->message,
            ]);

            // Gửi email với mã token
            Mail::to($contact->email)->send(new SendContactMail($contact->topic, $contact->email, $contact->username));

            return response()->json($contact, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Lỗi server'], 500);
        }
    }
}
