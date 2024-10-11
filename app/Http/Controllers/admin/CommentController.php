<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
class CommentController extends Controller
{
    public function list_comments(){
        $comments = Comment::all();
        return view('admin.comments.list-comments', compact('comments'));
    }
    public function update_comments($id){
        $comments = Comment::find($id);
        return view('admin.comments.update-comments',compact('comments'));
    }
    public function storeComment(Request $request, $id){
        $comments = Comment::find($id);
        $comments->comment = $request->comment;
        $comments->rating = $request->rating;
        if($comments->save()){
            return redirect('/list-comments')->with('success','Cập nhật bình luận thành công');
        } else {
            return redirect()->back()->with('error','Cập nhật bình luận thất bại');
        }
    }
    public function delete_comments($id){
        $comments = Comment::find($id);
        $comments->delete();
        return redirect('/list-comments')->with('success', 'Xoá bình luận thành công');
    }
}
