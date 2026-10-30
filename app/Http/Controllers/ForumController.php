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
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $current_user = Auth::user();
        $group = Auth::user()->group;

        if (Auth::user()->role == 'student' && $group) {
            $comments = Comment::where('group_id', $group->id)
                ->with(['user', 'reactions.user'])
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $comments = Comment::with(['user', 'reactions.user'])
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('student.forum.index', compact('group', 'current_user', 'comments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:10000',
        ]);

        $comment = new Comment;
        $comment->title = $validated['title'];
        $comment->content = $validated['content'];
        $comment->user_id = Auth::id();
        $comment->group_id = Auth::user()->group_id;

        $comment->save();

        return redirect()->route('forum.index');
    }

    public function show(Comment $comment)
    {
        $current_user = Auth::user();
        $comment->load(['user', 'reactions.user']);
        $replies = Reply::where('comment_id', $comment->id)
            ->with(['user', 'reactions.user'])
            ->orderBy('created_at', 'asc')
            ->get();
        $replies_number = $replies->count();

        return view('student.forum.show', compact('comment', 'replies', 'replies_number', 'current_user'));
    }

    public function destroy(Comment $comment)
    {

        if ($comment->user_id !== Auth::id() && Auth::user()->role !== 'teacher') {
            abort(403);
        }

        $comment->delete();

        return redirect()->route('forum.index');
    }
}
