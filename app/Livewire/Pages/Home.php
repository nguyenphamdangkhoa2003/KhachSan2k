<?php

namespace App\Livewire\Pages;

use App\Models\Carousel;
use App\Models\RoomType;
use Livewire\Attributes\Layout;
use Livewire\Component;
#[Layout("layouts.app")]
class Home extends Component
{
    public $slides = [];
    public $type_rooms;
    public function render()
    {
        $this->type_rooms = RoomType::limit(3)->get();
        $this->slides = Carousel::all()->toArray();
        return view('livewire.pages.home');
    }
}
