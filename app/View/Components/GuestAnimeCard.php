<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class GuestAnimeCard extends Component
{
    public $title;
    public $description;
    public $image;
    public $animeId;

    /**
     * Create a new component instance.
     */
    public function __construct($title, $description, $image, $animeId)
    {
        $this->title = $title;
        $this->description = $this->shortenDescription($description);
        $this->image = $image;
        $this->animeId = $animeId;
    }

    /**
     * Shorten the description to a specified length.
     */
    private function shortenDescription($description, $length = 100)
    {
        if (!$description) {
            return 'No description available.';
        }
        return strlen($description) > $length ? substr($description, 0, $length) . '...' : $description;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.guest-anime-card');
    }
}
