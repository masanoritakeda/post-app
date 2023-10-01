<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $inputs = request()->validate([
            'body' => 'required|max:255'
        ]);

        $comment = Comment::create([
            'body' => $inputs['body'],
            'user_id' => auth()->user()->id,
            'post_id' => $request->post_id
        ]);

        return back()->with('success', 'コメントが投稿されました');
    }

    public function destroy(Comment $comment)
    {
        // コメントを削除
        $comment->delete();

        // 削除後、元のページにリダイレクト
        return redirect()->back()->with('success', 'コメントが削除されました');
    }
}
