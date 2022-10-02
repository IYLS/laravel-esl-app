<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Models\User;
use App\Models\Group;
use App\Models\Reply;

class ForumController extends Controller
{
    public function __construct(){
        $this->middleware('student');
    }

    public function index()
    {
        $current_user = Auth::user();
        $group = Auth::user()->group;
        $comments = Comment::where('group_id', $group->id)->orderBy('created_at', 'desc')->get();

        return view('student.forum.index', compact('group', 'current_user', 'comments'));
    }

    public function store(Request $request)
    {
        $comment = new Comment;
        $comment->title = $request->title;
        $comment->content = $request->content;

        $comment->user_id = Auth::user()->id;
        $comment->group_id = Auth::user()->group_id;

        $comment->save();

        return redirect()->route('forum.index');
    }

    public function show($id)
    {
        $current_user = Auth::user();
        $comment = Comment::find($id);
        $replies = Reply::where('comment_id', $id)->orderBy('created_at', 'desc')->get();
        $replies_number = $replies->count();

        return view('student.forum.show', compact('comment', 'replies', 'replies_number', 'current_user'));
    }

    public function destroy($id)
    {
        Comment::find($id)->delete();

        return redirect()->route('forum.index');
    }
}
