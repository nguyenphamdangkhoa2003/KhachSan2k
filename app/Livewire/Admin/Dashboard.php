<?php

namespace App\Livewire\Admin;

use App\Models\RoomType;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $type_rooms = RoomType::all();
        return view('livewire.admin.dashboard')->with(compact('type_rooms'))->layout('layouts.app'); // Sử dụng layout trong đây
    }
}
