<?php

namespace App\Livewire;

use Livewire\Component;

class AnimeCard extends Component
{
    public $anime; // Receive anime data

    public function render()
    {
        return view('livewire.anime-card');
    }
}
