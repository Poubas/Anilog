<?php

namespace App\Http\Controllers;

use App\Models\AnimeList;
use Illuminate\Support\Facades\Auth;


class FavoriteListController extends Controller
{
    public function addFavorite(AnimeList $animeList)
    {
        Auth::user()->favoriteLists()->attach($animeList->id);
        return redirect()->back()->with('success', 'List added to favorites.');
    }

    public function removeFavorite(AnimeList $animeList)
    {
        Auth::user()->favoriteLists()->detach($animeList->id);
        return redirect()->back()->with('success', 'List removed from favorites.');
    }
}
