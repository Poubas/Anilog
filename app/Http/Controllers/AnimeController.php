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
        $query = $request->input('query', '');
        
        // Check if query is shorter than 4 characters and add a space if needed
        if (strlen($query) > 0 && strlen($query) < 4) {
            $query .= ' ';
        }
        
        $page = $request->input('page', 1);
        $perPage = 12;
        
        // Get sort parameter - default to score if not provided
        $sort = $request->input('sort', 'score');
        
        // Get sort direction - default to descending
        $direction = $request->input('direction', 'desc');
        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = 'desc';
        }
        
        // Get selected genres (included and excluded)
        $selectedGenres = $request->input('genres', []);
        $excludedGenres = $request->input('excluded_genres', []);
        
        // Map the sort parameter to the API's sort parameter
        $sortMap = [
            'popularity' => 'popularity',
            'score' => 'score',
            'title' => 'title',
            'newest' => 'start_date',
            'oldest' => 'end_date',
        ];
        
        $apiSort = $sortMap[$sort] ?? 'score';
        
        // Generate a unique cache key that includes direction and genres
        $genreKey = !empty($selectedGenres) ? implode(',', $selectedGenres) : 'none';
        $excludeKey = !empty($excludedGenres) ? implode(',', $excludedGenres) : 'none';
        $cacheKey = "anime_search_{$query}_sort_{$sort}_dir_{$direction}_genres_{$genreKey}_exclude_{$excludeKey}_page_{$page}";

        // Check if the data is already cached
        $data = Cache::remember($cacheKey, 60, function () use ($query, $page, $perPage, $apiSort, $direction, $selectedGenres, $excludedGenres) {
            try {
                if (empty($query)) {
                    $endpoint = 'https://api.jikan.moe/v4/top/anime';
                    $params = [
                        'page' => $page,
                        'limit' => $perPage,
                    ];
                    
                    // For top anime endpoint, handle specific sort types
                    if ($apiSort === 'score') {
                        // Default sorts by score
                    } elseif ($apiSort === 'popularity') {
                        $params['filter'] = 'bypopularity';
                    }
                    
                    // Add genres to the query if selected
                    if (!empty($selectedGenres)) {
                        $params['genres'] = implode(',', $selectedGenres);
                    }
                    
                    // Add excluded genres to the query if selected
                    if (!empty($excludedGenres)) {
                        $params['genres_exclude'] = implode(',', $excludedGenres);
                    }
                    
                } else {
                    $endpoint = 'https://api.jikan.moe/v4/anime';
                    $params = [
                        'q' => $query,
                        'sfw' => true,
                        'page' => $page,
                        'limit' => $perPage,
                        'order_by' => $apiSort,
                        'sort' => $direction,
                    ];
                    
                    // Add genres to the query if selected
                    if (!empty($selectedGenres)) {
                        $params['genres'] = implode(',', $selectedGenres);
                    }
                    
                    // Add excluded genres to the query if selected
                    if (!empty($excludedGenres)) {
                        $params['genres_exclude'] = implode(',', $excludedGenres);
                    }
                }
                
                $response = Http::get($endpoint, $params);
                if (!$response->successful()) {
                    \Log::error('Jikan API error: ' . $response->status() . ' - ' . $response->body());
                    return ['data' => [], 'pagination' => ['items' => ['total' => 0]]];
                }
                
                return $response->json();
            } catch (\Exception $e) {
                \Log::error('Error fetching anime data: ' . $e->getMessage());
                return ['data' => [], 'pagination' => ['items' => ['total' => 0]]];
            }
        });

        $animes = $data['data'] ?? [];
        $total = $data['pagination']['items']['total'] ?? 0;

        $paginator = new LengthAwarePaginator($animes, $total, $perPage, $page, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        // Sort options
        $sortOptions = [
            'score' => 'Highest Score',
            'popularity' => 'Most Popular',
            'title' => 'Title A-Z',
            'newest' => 'Data'
        ];

        // Available genres for filtering
        $genres = [
            ['id' => 1, 'name' => 'Action'],
            ['id' => 2, 'name' => 'Adventure'],
            ['id' => 5, 'name' => 'Avant Garde'],
            ['id' => 46, 'name' => 'Award Winning'],
            ['id' => 28, 'name' => 'Boys Love'],
            ['id' => 4, 'name' => 'Comedy'],
            ['id' => 8, 'name' => 'Drama'],
            ['id' => 10, 'name' => 'Fantasy'],
            ['id' => 26, 'name' => 'Girls Love'],
            ['id' => 47, 'name' => 'Gourmet'],
            ['id' => 14, 'name' => 'Horror'],
            ['id' => 7, 'name' => 'Mystery'],
            ['id' => 22, 'name' => 'Romance'],
            ['id' => 24, 'name' => 'Sci-Fi'],
            ['id' => 36, 'name' => 'Slice of Life'],
            ['id' => 30, 'name' => 'Sports'],
            ['id' => 37, 'name' => 'Supernatural'],
            ['id' => 41, 'name' => 'Suspense']
        ];

        // Pass everything to the view
        return view('anime.browse', compact('animes', 'query', 'paginator', 'sort', 'direction', 'sortOptions', 'genres', 'selectedGenres', 'excludedGenres'));
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
