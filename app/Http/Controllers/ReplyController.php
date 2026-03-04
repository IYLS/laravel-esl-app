<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reply;
use Illuminate\Support\Facades\Auth;


class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, $comment_id)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:5000',
        ]);

        $comment = \App\Models\Comment::findOrFail($comment_id);

        $reply = new Reply;
        $reply->content = $validated['content'];
        $reply->user_id = Auth::id();
        $reply->comment_id = $comment_id;
        $reply->save();

        return redirect()->route('forum.show', $comment_id);
    }
}
