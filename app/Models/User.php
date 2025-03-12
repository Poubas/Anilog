<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'bio',
        'profile_picture',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'followers', 'followed_id', 'follower_id')
                    ->withTimestamps();
    }

    public function following(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'followed_id')
                    ->withTimestamps();
    }

    public function isFollowing(User $user)
    {
        return $this->following()->where('followed_id', $user->id)->exists();
    }

    // Helper method to get users that this user follows
    public function followingUsers()
    {
        return User::whereHas('followers', function($query) {
            $query->where('follower_id', $this->id);
        });
    }

    // Helper method to get users that follow this user
    public function followerUsers() 
    {
        return User::whereHas('following', function($query) {
            $query->where('followed_id', $this->id);
        });
    }

    /**
     * Lists that the user has favorited
     */
    public function favoriteLists(): BelongsToMany
    {
        return $this->belongsToMany(AnimeList::class, 'favorite_lists')
                    ->withTimestamps();
    }

    public function hasFavorited(AnimeList $animeList)
    {
        return $this->favoriteLists()->where('anime_list_id', $animeList->id)->exists();
    }

    public function animeLists(): HasMany
    {
        return $this->hasMany(AnimeList::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get the user's comments.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
