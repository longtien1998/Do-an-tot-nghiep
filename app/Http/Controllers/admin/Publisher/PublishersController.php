<?php

namespace App\Http\Controllers\admin\Publisher;

use App\Http\Controllers\Controller;
use App\Models\PublishersModel;
use Illuminate\Http\Request;
use App\Http\Requests\Pulishers\PulisherRequest;

class PublishersController extends Controller
{

    public function index(Request $request)
    {
        $perPage = 10;

        if ($request->isMethod('post')) {
            $perPage = $request->indexPage;
        }
        $publishers = PublishersModel::paginate($perPage);
        return view('admin.publishers.index', compact('publishers'));
    }
    public function create()
    {
        return view('admin.publishers.create');
    }
    public function store(PulisherRequest $request)
    {

        try {
            if ($request->hasFile('logo')) {
                $file_image = $request->file('logo');
                $Pulisher = $request->publisher_name;
                $logo = PublishersModel::up_image_Pulisher($file_image, $Pulisher);
            } else {
                $logo = null;
            }
            $data = $request->except('_token');
            $data['logo'] = $logo;
            PublishersModel::create($data);
            return redirect()->route('publishers.index')->with('success', 'Thêm mới nhà xuất bản thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Thêm mới nhà xuất bản thất bại'.$e->getMessage());
        }
    }
    public function edit($id)
    {
        $publisher = PublishersModel::find($id);
        return view('admin.publishers.edit', compact('publisher'));
    }
    public function update(Request $request,$id)
    {
        $publisher = PublishersModel::find($id);
        $data = $request->except('_token');
        try {
            if ($request->hasFile('logo')) {
                $file_image = $request->file('logo');
                $Pulisher = $request->publisher_name;
                $logo = PublishersModel::up_image_Pulisher($file_image, $Pulisher);
                $data['logo'] = $logo;
            } else {
                $data['logo'] = $publisher->logo;
            }

            $publisher->update($data);
            return redirect()->route('publishers.index')->with('success', 'Cập nhật nhà xuất bản thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Cập nhật nhà xuất bản thất bại, '.$e->getMessage());
        }

    }
    public function delete($id)
    {
        try {
            PublishersModel::find($id)->delete();
            return redirect()->route('publishers.index')->with('success', 'Xóa nhà xuất bản thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa bài hát thất bại.');
        }

    }

    public function delete_list(Request $request)
    {
        // dd($request->delete_list);
        $deletelist = json_decode($request->delete_list, true);
        if (is_array($deletelist)) {
            try {
                foreach ($deletelist as $list) {
                    $song = PublishersModel::find($list);
                    $song->delete();
                }
                return redirect()->route('publishers.index')->with('success', 'Xóa nhà xuất bản thành công');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa bài hát thất bại.');
            }
        } else {
            return redirect()->back()->with('error', 'Xoá bài hát thất bại!');
        }

    }


    
}
