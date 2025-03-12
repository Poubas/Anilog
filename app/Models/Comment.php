<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'anime_list_id',
        'content',
        'parent_id'
    ];
    
    /**
     * Get the user who wrote the comment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the anime list this comment belongs to.
     */
    public function animeList()
    {
        return $this->belongsTo(AnimeList::class);
    }
    
    /**
     * Get replies to this comment.
     */
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
    
    /**
     * Get parent comment if this is a reply.
     */
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }
}
