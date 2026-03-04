<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CommentReaction;
use App\Models\ReplyReaction;

class ReactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function comment(Request $request, $commentId)
    {
        $request->validate([
            'emoji' => 'required|string|max:20',
        ]);

        \App\Models\Comment::findOrFail($commentId);

        $existing = CommentReaction::where('comment_id', $commentId)
            ->where('user_id', Auth::id())
            ->where('emoji', $request->emoji)
            ->first();

        if ($existing) {
            $existing->delete();
        } else {
            CommentReaction::create([
                'comment_id' => $commentId,
                'user_id' => Auth::id(),
                'emoji' => $request->emoji,
            ]);
        }

        $reactions = CommentReaction::where('comment_id', $commentId)
            ->with('user')
            ->get()
            ->groupBy('emoji')
            ->map(function ($group) {
                return [
                    'emoji' => $group->first()->emoji,
                    'count' => $group->count(),
                    'user_reacted' => $group->contains('user_id', Auth::id()),
                    'users' => $group->pluck('user.name')->toArray(),
                ];
            })
            ->values();

        return response()->json(['reactions' => $reactions]);
    }

    public function reply(Request $request, $replyId)
    {
        $request->validate([
            'emoji' => 'required|string|max:20',
        ]);

        \App\Models\Reply::findOrFail($replyId);

        $existing = ReplyReaction::where('reply_id', $replyId)
            ->where('user_id', Auth::id())
            ->where('emoji', $request->emoji)
            ->first();

        if ($existing) {
            $existing->delete();
        } else {
            ReplyReaction::create([
                'reply_id' => $replyId,
                'user_id' => Auth::id(),
                'emoji' => $request->emoji,
            ]);
        }

        $reactions = ReplyReaction::where('reply_id', $replyId)
            ->with('user')
            ->get()
            ->groupBy('emoji')
            ->map(function ($group) {
                return [
                    'emoji' => $group->first()->emoji,
                    'count' => $group->count(),
                    'user_reacted' => $group->contains('user_id', Auth::id()),
                    'users' => $group->pluck('user.name')->toArray(),
                ];
            })
            ->values();

        return response()->json(['reactions' => $reactions]);
    }
}
