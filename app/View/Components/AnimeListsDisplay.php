<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnimeListsDisplay extends Component
{
    public $lists;
    
    /**
     * Create a new component instance.
     *          
     * @return void
     */
    public function __construct($user = null)
    {
        // Get the user or default to authenticated user
        $user = $user ?? Auth::user();
        
        // Initialize with empty collection by default
        $this->lists = collect();
        
        // Only try to get anime lists if user exists and relationship is defined
        if ($user && method_exists($user, 'animeLists')) {
            try {
                // Get lists without eager loading animes
                $this->lists = $user->animeLists()->get();
                
                // Manually add anime count to each list
                foreach ($this->lists as $list) {
                    // Count anime in list using direct DB query
                    $list->anime_count = DB::table('anime_list_anime')
                        ->where('anime_list_id', $list->id)
                        ->count();
                }
                
                // Debug output
                \Log::info('Lists found: ' . $this->lists->count());
            } catch (\Exception $e) {
                // Log error but don't crash
                \Log::error('Error loading anime lists: ' . $e->getMessage());
            }
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.anime-lists-display');
    }
}
