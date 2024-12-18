<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function index(Request $request){
        $perPage = 20;
        $filterCreateStart = false;
        $filterCreateEnd = false;
        $filterStatus = false;
        if ($request->isMethod('post')) {
            $perPage = $request->indexPage;
            $filterCreateStart = $request->input('filterCreateStart');
            $filterCreateEnd = $request->input('filterCreateEnd');
            $filterStatus = $request->input('filterStatus');
        }
        $contacts = Contact::getAll($perPage, $filterCreateStart, $filterCreateEnd, $filterStatus);
        return view('admin.contact.index', compact('contacts'));

    }

    public function update(Request $request,$id){
        $validatedData = Validator::make($request->all(), [
            'contact_status' => 'required|string|max:255',
        ], [
            'contact_status.required' => 'Trạng thái hỗ trợ không được để trống',
            'contact_status.string' => 'Trạng thái hỗ trợ phải là một chuỗi',
            'contact_status.max' => 'Trạng thái hỗ trợ không quá 255 ký tự',
        ]);
        if ($validatedData->fails()) {
            return redirect()->back()->withErrors($validatedData);
        }
        $contact = Contact::find($id);
        if (!$contact) {
            return redirect()->route('admin.contact.index')->with('error', 'Không tìm thấy hổ trợ');
        }
        $contact->status = $request->contact_status;
        $contact->save();
        return redirect()->route('contacts.index')->with('success', 'Cập nhật thành công');
    }
}
