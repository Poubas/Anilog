<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

class AnimeList extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'description', 
        'user_id',
        'image'
    ];

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return Storage::url($this->image);
        }
        return null;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function animes() : BelongsToMany
    {
        // Use mal_id instead of anime_id to match your database schema
        return $this->belongsToMany(Anime::class, 'anime_list_anime', 'anime_list_id', 'mal_id');
    }

    /**
     * Users who have favorited this list
     */
    public function favoritedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorite_lists')
                    ->withTimestamps();
    }

    /**
     * Get the comments for this anime list.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
