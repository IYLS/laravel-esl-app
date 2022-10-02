<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reply;
use Illuminate\Support\Facades\Auth;


class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('student');
    }

    public function store(Request $request, $comment_id)
    {
        $reply = new Reply;
        $reply->content = $request->content;

        $reply->user_id = Auth::user()->id;
        $reply->comment_id = $comment_id;
        $reply->save();

        return redirect()->route('forum.show', $comment_id);
    }
}
