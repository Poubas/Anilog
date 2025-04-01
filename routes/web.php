<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnimeController;
use App\Http\Controllers\FavoriteListController;
use App\Http\Controllers\AnimeListController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;

Route::get("/", [HomeController::class, 'welcome'])->name('welcome');

Route::get("/dashboard", function () {
    return view("dashboard");
})
    ->middleware(["auth", "verified"])
    ->name("dashboard");

Route::get('/anime', [AnimeController::class, 'index'])->name('anime.browse');
Route::get('/anime/{id}', [AnimeController::class, 'show'])->name('anime.show');

Route::get('/anime/guest/{id}', [HomeController::class, 'showAnime'])->name('anime.guest.show');

Route::get('/anime-lists/browse', [AnimeListController::class, 'browseAllLists'])
    ->name('anime-lists.browse');

Route::get('/community/anime-lists/{animeList}', [AnimeListController::class, 'showCommunityList'])
    ->name('community.anime-lists.show');

Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');

// User follow routes
Route::post('/users/{user}/follow', [UserController::class, 'follow'])->middleware(['auth'])->name('users.follow');
Route::delete('/users/{user}/unfollow', [UserController::class, 'unfollow'])->middleware(['auth'])->name('users.unfollow');
Route::get('/users/following', [UserController::class, 'following'])->middleware(['auth'])->name('users.following');
Route::get('/users/followers', [UserController::class, 'followers'])->middleware(['auth'])->name('users.followers');

Route::middleware("auth")->group(function () {
    Route::get("/profile", [ProfileController::class, "edit"])->name(
        "profile.edit"
    );
    Route::patch("/profile", [ProfileController::class, "update"])->name(
        "profile.update"
    );
    Route::patch("/profile/picture", [ProfileController::class, 'updatePicture'])->name(
        "profile.updatePicture"
    );
    Route::patch('/profile/bio', [ProfileController::class, 'updateBio'])->name('profile.updateBio');
    Route::delete("/profile", [ProfileController::class, "destroy"])->name(
        "profile.destroy"
    );
    Route::post('/anime-lists/{animeList}/favorite', [FavoriteListController::class, 'addFavorite'])->name(
        'anime-lists.favorite'
    );
    Route::delete('/anime-lists/{animeList}/favorite', [FavoriteListController::class, 'removeFavorite'])->name(
        'anime-lists.unfavorite'
    );
    Route::post('/anime-lists/{animeList}/favorite', [AnimeListController::class, 'toggleFavorite'])
        ->middleware(['auth'])
        ->name('anime-lists.toggle-favorite');
    Route::resource('anime-lists', AnimeListController::class);
    Route::post('/anime-lists/add-anime', [AnimeListController::class, 'addAnimeToList'])
        ->middleware(['auth'])
        ->name('anime-lists.add-anime');
    Route::delete('/anime-lists/{animeList}/anime/{anime}', [AnimeListController::class, 'removeAnime'])
        ->middleware(['auth'])
        ->name('anime-lists.remove-anime');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::post('/anime-lists/{animeList}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

require __DIR__ . "/auth.php";
