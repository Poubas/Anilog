<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\AnimeList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, AnimeList $animeList)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id'
        ]);
        
        $comment = new Comment([
            'content' => $validated['content'],
            'parent_id' => $validated['parent_id'] ?? null,
            'user_id' => Auth::id()
        ]);
        
        $animeList->comments()->save($comment);
        
        return back()->with('success', 'Comment posted successfully.');
    }
    
    public function destroy(Comment $comment)
    {
        // Check if user owns the comment or is the list owner
        if (Auth::id() === $comment->user_id || Auth::id() === $comment->animeList->user_id) {
            $comment->delete();
            return back()->with('success', 'Comment deleted successfully.');
        }
        
        return back()->with('error', 'You are not authorized to delete this comment.');
    }
}
