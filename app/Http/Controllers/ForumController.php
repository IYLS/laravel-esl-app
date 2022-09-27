<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Models\User;
use App\Models\Group;

class ForumController extends Controller
{
    public function index()
    {
        $current_user = Auth::user();
        $group = Auth::user()->group;

        $comments = Comment::where('group_id', $group->id)->orderBy('created_at', 'desc')->get();

        return view('student.forum.index', compact('group', 'current_user', 'comments'));
    }

    public function create()
    {
        //
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
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
