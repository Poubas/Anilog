<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Http;

class CarregarAnimes extends Component
{
    use WithPagination;

    public $perPage = 9; // Number of anime per page
    public $page;

    public function fetchAnime()
    {
        $page = $this->page; // Get current pagination page
        $response = Http::get("https://api.jikan.moe/v4/anime", [
            'page' => $page,
            'limit' => $this->perPage
        ]);

        return $response->successful() ? $response->json()['data'] : [];
    }

    public function render()
    {
        return view('livewire.carregar-animes', [
            'animeList' => $this->fetchAnime()
        ]);
    }
}
