<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use App\Models\Anime;
use Illuminate\Support\Facades\Auth;

class AnimeController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query', ''); // Default to an empty string if no query is provided
        $page = $request->input('page', 1); // Get the current page or default to 1
        $perPage = 12; // Number of items per page

        // Generate a unique cache key based on the query and page
        $cacheKey = "anime_search_{$query}_page_{$page}";

        // Check if the data is already cached
        $data = Cache::remember($cacheKey, 60, function () use ($query, $page, $perPage) {
            $response = Http::get('https://api.jikan.moe/v4/anime', [
                'q' => $query,
                'sfw' => true,
                'page' => $page,
                'limit' => $perPage,
            ]);

            return $response->json();
        });

        $animes = $data['data'] ?? [];
        $total = $data['pagination']['items']['total'] ?? 0;

        $paginator = new LengthAwarePaginator($animes, $total, $perPage, $page, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        return view('anime.browse', compact('animes', 'query', 'paginator'));
    }

    public function show($id)
    {
        // Cache the anime details from API (your existing code)
        $animeData = Cache::remember("anime_{$id}", 30 * 60, function () use ($id) {
            $response = Http::get("https://api.jikan.moe/v4/anime/{$id}");
            return $response->json();
        });
        
        // Extract the anime details from the response
        $anime = $animeData['data'] ?? null;
        
        if (!$anime) {
            abort(404, 'Anime not found');
        }
        
        // IMPORTANT: Make sure this anime exists in our database
        // This creates or updates the anime record in our database
        $dbAnime = \App\Models\Anime::updateOrCreate(
            ['mal_id' => $id],  // Find by MAL ID
            [
                'title' => $anime['title'],
                'image_url' => $anime['images']['jpg']['image_url'] ?? null,
                // Add other fields you want to store
            ]
        );
        
        // Now we can safely use $dbAnime->id
        
        // Get reviews for this anime
        $reviews = \App\Models\Review::where('anime_id', $dbAnime->id)
                    ->with('user')
                    ->latest()
                    ->get();
        
        // Check if current user has already reviewed
        $userReview = null;
        if (Auth::check()) {
            $userReview = \App\Models\Review::where('user_id', Auth::id())
                            ->where('anime_id', $dbAnime->id)
                            ->first();
        }
        
        // Calculate review stats
        $reviewStats = null;
        if ($reviews->count() > 0) {
            $total = $reviews->count();
            $positive = $reviews->where('is_positive', true)->count();
            
            $reviewStats = [
                'total' => $total,
                'positive' => $positive,
                'negative' => $total - $positive,
                'percentage' => $total > 0 ? round(($positive / $total) * 100) : 0
            ];
        }
        
        // Get the user's anime lists for the dropdown
        $userLists = auth()->user() ? auth()->user()->animeLists : collect();
        
        return view('anime.showAnime', compact('anime', 'dbAnime', 'reviews', 'userReview', 'reviewStats', 'userLists'));
    }
}
