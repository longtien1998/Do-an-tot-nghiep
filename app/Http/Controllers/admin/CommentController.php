<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
class CommentController extends Controller
{
    public function list_comments(){
        $comments = Comment::selectCmt();
        return view('admin.comments.list-comments', compact('comments'));
    }
    public function edit_comments($id){
        $comments = Comment::find($id);
        return view('admin.comments.update-comments',compact('comments'));
    }
    public function update_comments(Request $request, $id){
        $comments = Comment::find($id);
        $comments->comment = $request->comment;
        $comments->rating = $request->rating;
        if($comments->save()){
            toastr()->success('Cập nhật bình luận thành công');
            return redirect()->route('comments.list');
        } else {
            toastr()->error('Cập nhật bình luận thất bại');
            return redirect()->back();
        }
    }

    public function list_trash_comments()

    {
        $comments = Comment::onlyTrashed()->paginate(10);
        return view('admin.comments.list-trash-comments', compact('comments'));
    }

    public function delete_comments($id)
{
    try {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return redirect()->route('comments.list')->with('success', 'Xoá bình luận thành công!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa bình luận thất bại.');
    }
}

    public function delete_trash_comments(Request $request)
    {
        // dd($request->delete_list);
        // Giải mã chuỗi JSON thành mảng
        $deleteList = json_decode($request->delete_list, true);
        if (is_array($deleteList)) {
            try {
                foreach ($deleteList as $delete) {
                    Comment::withTrashed()->where('id', $delete)->forceDelete();
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa bình luận khỏi thùng rác thất bại.');
            }
            return redirect()->back()->with('success', 'Xóa bình luận khỏi thùng rác thành công!');
        } else {
            return redirect()->back()->with('error', 'Xóa bình luận khỏi thùng rác thất bại!');
        }
    }

    public function delete_list_comments(Request $request)
    {
        // dd($request->delete_list);
        $deletelist = json_decode($request->delete_list, true);
        if (is_array($deletelist)) {
            try {
                foreach ($deletelist as $list) {
                    $comments = Comment::find($list);
                    $comments->deleted_at = now();
                    $comments->save();
                }
                return redirect()->route('comments.list')->with('success', 'Xoá bình luận thành công!');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa bình luận thất bại.');
            }
        } else {
            return redirect()->back()->with('error', 'Xoá bình luận thất bại!');
        }
    }



    public function restore_trash_comments(Request $request)
    {
        // dd($request->restore_list);
        // Giải mã chuỗi JSON thành mảng
        $restoreList = json_decode($request->restore_list, true);
        if (is_array($restoreList)) {
            try {
                foreach ($restoreList as $restore) {
                    Comment::withTrashed()->where('id', $restore)->restore();
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra. Khôi phục bình luận khỏi thùng rác thất bại.');
            }
            return redirect()->back()->with('success', 'Khôi phục bình luận khỏi thùng rác thành công!');
        } else {
            return redirect()->back()->with('error', 'Khôi phục bình luận khỏi thùng rác thất bại!');
        }
    }


    public function restore_all_comments()
    {
        try {
            Comment::withTrashed()->restore();
            return redirect()->back()->with('success', 'Khôi phục tất cả bình luận khỏi thùng rác thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Khôi phục bình luận khỏi thùng rác thất bại.');
        }
    }


    public function delete_all_comments()
    {
        try {
            Comment::withTrashed()->forceDelete();
            return redirect()->back()->with('success', 'Xóa tất cả bình luận khỏi thùng rác thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa bình luận khỏi thùng rác thất bại.');
        }
    }


    public function destroy_trash_comments($id)
{
    session()->forget('error');

    try {
        $comment = Comment::withTrashed()->find($id);

        if ($comment) {
            $comment->forceDelete();
            return redirect()->route('comments.trash.list')->with('success', 'Xóa bình luận khỏi thùng rác thành công!');
        } else {
            return redirect()->back()->with('error', 'Bình luận không tồn tại trong thùng rác.');
        }
    } catch (\Exception $e) {
        // dd($e->getMessage());
        return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa bình luận khỏi thùng rác thất bại.');
    }
}


    public function searchComments(Request $request)
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
            $comments = Comment::search_cmt($query);
            if ($comments->isEmpty()) {
                return redirect()->route('comments.list')->with('error', 'Không tìm thấy bình luận nào phù hợp với từ khóa');

            } else {
                toastr()->success('Tìm bình luận thành công');
                return view('admin.comments.list-comments', compact('comments'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Không tìm thấy bình luận nào phù hợp với từ khóa.');
        }
    }
    public function search_comments_trash(Request $request)
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
            $comments = Comment::onlyTrashed()->where('comment', 'LIKE', '%' . $query . '%')->get();
            if ($comments->isEmpty()) {
                return redirect()->route('comments.trash.list')->with('error', 'Không tìm thấy bình luận nào phù hợp với từ khóa');
            } else {
                toastr()->success('Tìm bình luận thành công');
                return view('admin.comments.list-trash-comments', compact('comments'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Không tìm thấy bình luận nào phù hợp với từ khóa.');
        }
    }
}

