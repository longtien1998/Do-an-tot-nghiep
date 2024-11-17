<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;



class CommentController extends Controller
{
    public function add_comment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id',
            'song_id',
            'comment',
            'rating' => 'numeric|max:5|min:1'
        ], [
            'rating.max' => 'Đánh giá tối đa 5 sao',
            'rating.min' => 'Đánh giá tối thiểu 1 sao',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }

        $data = $request->all();
        if (Comment::where('user_id', $data['user_id'])
            ->where('song_id', $data['song_id'])
            ->where('rating', $data['rating'])->first()
        ) {
            return response()->json(['message' => 'Bạn đã bình luận về bài hát này'], 400);
        }
        $add = Comment::create($data);
        // dd($data);
        return response()->json($add);
    }
    public function show_comment($id){
        try {
            $comment = Comment::where('song_id',$id)->get();
            // dd($comment);
            if($comment->isEmpty()){
                return response()->json(['message'=>'Không có bình luận nào'],400);
            }
        return response()->json($comment);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Lỗi'], 400);
        }
    }
}
