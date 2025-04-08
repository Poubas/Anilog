<?php

namespace App\Http\Controllers;

use App\Models\AnimeList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Anime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AnimeListController extends Controller
{
    public function index()
    {
        $animeLists = Auth::user()->animeLists;
        return view('anime.index', compact('animeLists'));
    }

    public function create()
    {
        return view('anime.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $animeList = new AnimeList();
        $animeList->name = $request->input('name');
        $animeList->description = $request->input('description');
        $animeList->user_id = Auth::id();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('anime_lists', 'public');
            $animeList->image = $path;
        }

        $animeList->save();

        return redirect()->route('dashboard')
            ->with('success', 'Anime list created successfully.');
    }

    public function show(AnimeList $animeList)
    {
        // Check if the user is the owner
        $isOwner = Auth::check() && Auth::id() === $animeList->user_id;
        
        // If not the owner, redirect to the community view
        if (!$isOwner) {
            return redirect()->route('community.anime-lists.show', $animeList);
        }
        
        // Rest of your existing show method code...
        $animes = DB::table('animes')
            ->join('anime_list_anime', 'animes.id', '=', 'anime_list_anime.mal_id')
            ->where('anime_list_anime.anime_list_id', $animeList->id)
            ->select('animes.*')
            ->get();
        
        $animeCount = $animes->count();
        
        // Get comments, eager load relationships to reduce queries
        $comments = $animeList->comments()
            ->with(['user', 'replies.user'])
            ->whereNull('parent_id') // Get only root comments
            ->latest()
            ->get();
        
        return view('anime.showList', compact('animeList', 'animes', 'animeCount', 'comments'));
    }

    public function edit(AnimeList $animeList)
    {
        return view('anime.edit', compact('animeList'));
    }

    public function update(Request $request, AnimeList $animeList)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $animeList->name = $request->input('name');
        $animeList->description = $request->input('description');

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($animeList->image) {
                Storage::disk('public')->delete($animeList->image);
            }

            $path = $request->file('image')->store('anime_lists', 'public');
            $animeList->image = $path;
        }

        $animeList->save();

        return redirect()->route('anime-lists.show', $animeList)
            ->with('success', 'Anime list updated successfully.');
    }

    public function destroy(AnimeList $animeList)
    {
        // Delete the image file if it exists
        if ($animeList->image) {
            Storage::disk('public')->delete($animeList->image);
        }

        $animeList->delete();
        return redirect()->route('dashboard')
            ->with('success', 'Anime list deleted successfully.');
    }

    public function addAnimeToList(Request $request)
    {
        $validated = $request->validate([
            'anime_id' => 'required|numeric',  // Changed from mal_id to match the form
            'anime_title' => 'required|string',
            'anime_image' => 'nullable|string',
            'list_id' => 'required|exists:anime_lists,id'
        ]);
        
        $animeList = AnimeList::findOrFail($validated['list_id']);
        
        // Check if user owns this list
        if ($animeList->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action');
        }
        
        // Check if we already have this anime in our database
        $anime = \App\Models\Anime::firstOrCreate(
            ['mal_id' => $validated['anime_id']],  // This is now matching a field in the anime table
            [
                'title' => $validated['anime_title'],
                'image_url' => $validated['anime_image'] ?? null,
            ]
        );
        
        // Use DB facade to check directly and safely
        $exists = \Illuminate\Support\Facades\DB::table('anime_list_anime')
            ->where('anime_list_id', $animeList->id)
            ->where('mal_id', $anime->id)  // Use mal_id as this is your column name
            ->exists();
        
        if (!$exists) {
            // Insert directly with DB facade to ensure column names match
            \Illuminate\Support\Facades\DB::table('anime_list_anime')->insert([
                'anime_list_id' => $animeList->id,
                'mal_id' => $anime->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $message = 'Anime added to list successfully';
        } else {
            $message = 'Anime is already in this list';
        }
        
        return back()->with('success', $message);
    }

    public function removeAnime(AnimeList $animeList, Anime $anime)
    {
        // Check if the user is authorized to modify this list
        if ($animeList->user_id !== Auth::id()) {
            abort(403);
        }
        
        // Use direct DB query to avoid relationship issues with column names
        DB::table('anime_list_anime')
            ->where('anime_list_id', $animeList->id)
            ->where('mal_id', $anime->id)
            ->delete();
        
        return back()->with('success', 'Anime removed from list successfully.');
    }

    public function browseAllLists(Request $request)
    {
        // Get sort parameters from request (default to newest)
        $sort = $request->input('sort', 'newest');
        
        // Start query with base conditions 
        $query = AnimeList::with('user');
        
        // Apply sorting
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'alphabetical':
                $query->orderBy('name', 'asc');
                break;
            case 'most_anime':
                // This would require a subquery to count anime in each list
                $query->withCount('animes')->orderBy('animes_count', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
        
        // Paginate results
        $communityLists = $query->paginate(12);
        
        // Manually add anime counts to avoid relationship issues
        foreach ($communityLists as $list) {
            $list->anime_count = DB::table('anime_list_anime')
                ->where('anime_list_id', $list->id)
                ->count();
        }
        
        return view('anime.browse-lists', compact('communityLists', 'sort'));
    }

    public function showCommunityList(AnimeList $animeList)
    {
        // Your existing code to get anime data and creator
        $animes = $animeList->animes()->get();
        $animeCount = $animes->count();
        $creator = $animeList->user;
        $isOwner = Auth::check() && Auth::id() === $animeList->user_id;
        
        // Add this: load comments for the community list view
        $comments = $animeList->comments()
            ->with(['user', 'replies.user'])
            ->whereNull('parent_id') // Only get root comments
            ->latest()
            ->get();
        
        return view('anime.view-community-list', compact('animeList', 'animes', 'animeCount', 'creator', 'isOwner', 'comments'));
    }

    /**
     * Toggle favorite status of a list
     */
    public function toggleFavorite(AnimeList $animeList)
    {
        // Can't favorite your own lists
        if (Auth::id() === $animeList->user_id) {
            return back()->with('error', 'You cannot favorite your own lists.');
        }
        
        // Check if already favorited
        if (Auth::user()->hasFavorited($animeList)) {
            // Remove from favorites
            Auth::user()->favoriteLists()->detach($animeList->id);
            $message = 'List removed from favorites.';
        } else {
            // Add to favorites
            Auth::user()->favoriteLists()->attach($animeList->id);
            $message = 'List added to favorites.';
        }
        
        return back()->with('success', $message);
    }
}
