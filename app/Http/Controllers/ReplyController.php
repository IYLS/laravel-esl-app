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

    public function store(Request $request, \App\Models\Comment $comment)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:5000',
        ]);

        $reply = new Reply;
        $reply->content = $validated['content'];
        $reply->user_id = Auth::id();
        $reply->comment_id = $comment->id;
        $reply->save();

        return redirect()->route('forum.show', $comment);
    }
}
