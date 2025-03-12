<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Anime extends Model
{
    use HasFactory;

    protected $fillable = ['mal_id', 'title', 'image_url'];

    public function lists() : BelongsToMany
    {
        // Use mal_id instead of anime_id to match your database schema
        return $this->belongsToMany(AnimeList::class, 'anime_list_anime', 'mal_id', 'anime_list_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Helper method to get review stats
    public function getReviewStats()
    {
        $stats = [
            'total' => $this->reviews()->count(),
            'positive' => $this->reviews()->where('is_positive', true)->count(),
            'negative' => $this->reviews()->where('is_positive', false)->count(),
        ];
        
        $stats['percentage'] = $stats['total'] > 0 
            ? round(($stats['positive'] / $stats['total']) * 100) 
            : 0;
            
        return $stats;
    }
}
