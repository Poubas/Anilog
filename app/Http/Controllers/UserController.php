<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Follower;

class UserController extends Controller
{
    public function show(User $user)
    {
        // Get user's anime lists
        $lists = $user->animeLists;
        
        // Count their total anime (using direct DB query to avoid relationship issues)
        $totalAnime = 0;
        foreach ($lists as $list) {
            $list->anime_count = DB::table('anime_list_anime')
                ->where('anime_list_id', $list->id)
                ->count();
            $totalAnime += $list->anime_count;
        }
        
        // Check if viewing own profile
        $isOwnProfile = Auth::id() === $user->id;
        
        return view('users.profile', compact('user', 'lists', 'totalAnime', 'isOwnProfile'));
    }

    public function follow(User $user)
    {
        // Can't follow yourself
        if (Auth::id() === $user->id) {
            return back()->with('error', 'You cannot follow yourself.');
        }
        
        // Check if already following
        if (!Auth::user()->isFollowing($user)) {
            // Create follow relationship
            Follower::create([
                'follower_id' => Auth::id(),
                'followed_id' => $user->id
            ]);
            
            return back()->with('success', "You are now following {$user->name}.");
        }
        
        return back()->with('info', "You're already following {$user->name}.");
    }

    public function unfollow(User $user)
    {
        // Delete the follow relationship
        Follower::where('follower_id', Auth::id())
               ->where('followed_id', $user->id)
               ->delete();
        
        return back()->with('success', "You have unfollowed {$user->name}.");
    }

    public function following()
    {
        $user = Auth::user();
        $following = $user->following()->paginate(20);
        
        return view('users.following', compact('following', 'user'));
    }

    public function followers()
    {
        $user = Auth::user();
        $followers = $user->followers()->paginate(20);
        
        return view('users.followers', compact('followers', 'user'));
    }
}