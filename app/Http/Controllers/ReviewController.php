<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Anime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'anime_id' => 'required|exists:animes,id',
            'is_positive' => 'required|boolean',
            'content' => 'required|string|max:1000',
        ]);
        
        // Check if user already reviewed this anime
        $existingReview = Review::where('user_id', Auth::id())
                               ->where('anime_id', $validated['anime_id'])
                               ->first();
                               
        if ($existingReview) {
            // Update existing review
            $existingReview->update([
                'is_positive' => $validated['is_positive'],
                'content' => $validated['content']
            ]);
            
            $message = 'Your review has been updated.';
        } else {
            // Create new review
            Review::create([
                'user_id' => Auth::id(),
                'anime_id' => $validated['anime_id'],
                'is_positive' => $validated['is_positive'],
                'content' => $validated['content']
            ]);
            
            $message = 'Your review has been submitted.';
        }
        
        return redirect()->back()->with('success', $message);
    }
    
    public function destroy(Review $review)
    {
        // Check if the user is authorized to delete this review
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }
        
        $review->delete();
        return redirect()->back()->with('success', 'Your review has been deleted.');
    }
}