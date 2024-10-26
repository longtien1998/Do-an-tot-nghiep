<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use Illuminate\Support\Facades\Validator;

class CountriesController extends Controller
{
    public function index()
    {
        $countries = Country::paginate(10);
        return view('admin.music.country.country', compact('countries'));
    }

    public function store_country(Request $request)
    {
        // dd($request->all());
        $validate = Validator::make($request->all(),[
            'name_country' => 'required|string',
        ],[
            'name_country.required' => 'Tên quốc gia không được để trống.',
            'name_country.string' => 'Tên quốc gia phải là chuỗi ký tự',
        ]);
        if($validate->fails()) {
            // dd($validate);
            // Toastr()->error($validate->messages());
            return redirect()->back()->withErrors($validate);
        }

        Country::create($request->all());
        return redirect()->route('list-country')->with('success', 'Thêm mới quốc gia thành công.');
    }
}
