<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reply;
use Illuminate\Support\Facades\Auth;


class ReplyController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
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
