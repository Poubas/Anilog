<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use App\Models\Anime;

class HomeController extends Controller
{
    /**
     * Display the welcome page with popular anime.
     *
     * @return \Illuminate\View\View
     */
    public function welcome()
    {
        try {
            // Retrieve popular anime for the welcome page
            $response = Http::get('https://api.jikan.moe/v4/top/anime', [
                'page' => request('page', 1),
                'limit' => 12
            ]);
            
            if ($response->successful()) {
                $data = $response->json();
                $animes = $data['data'];
                
                // Create a paginator similar to browse page
                $paginator = new LengthAwarePaginator(
                    $animes,
                    $data['pagination']['items']['total'] ?? count($animes),
                    12,
                    request('page', 1),
                    ['path' => route('welcome')]
                );
                
                return view('welcome', [
                    'animes' => $animes,
                    'paginator' => $paginator
                ]);
            }
        } catch (\Exception $e) {
            // Log error but don't expose it to users
            \Log::error('Error fetching anime for welcome page: ' . $e->getMessage());
        }
        
        // Fallback: show welcome page without anime data
        return view('welcome');
    }

    /**
     * Display the anime details for guest users.
     * 
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function showAnime($id)
    {
        // Cache the anime details from API (similar to AnimeController)
        $animeData = Cache::remember("anime_{$id}", 30 * 60, function () use ($id) {
            $response = Http::get("https://api.jikan.moe/v4/anime/{$id}");
            return $response->json();
        });
        
        // Extract the anime details from the response
        $anime = $animeData['data'] ?? null;
        
        if (!$anime) {
            abort(404, 'Anime not found');
        }
        
        // For guests, we'll keep track of the anime in our database too
        $dbAnime = Anime::updateOrCreate(
            ['mal_id' => $id],
            [
                'title' => $anime['title'],
                'image_url' => $anime['images']['jpg']['image_url'] ?? null,
                // Add other fields you want to store
            ]
        );
        
        // Get reviews (no user-specific data for guest view)
        $reviews = \App\Models\Review::where('anime_id', $dbAnime->id)
                    ->with('user')
                    ->latest()
                    ->get();
        
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
        
        return view('anime.guest-show-anime', compact('anime', 'dbAnime', 'reviews', 'reviewStats'));
    }
}
