<?php

namespace App\Livewire\Admin\Component;

use App\Livewire\Forms\RoomTypeForm;
use App\Models\RoomType;
use Livewire\Component;

class TyperoomTable extends Component
{
    public $id;
    public $type_rooms;
    public RoomTypeForm $type_room;
    public function mount($type_rooms)
    {
        $this->$type_rooms = $type_rooms;
    }
    public function render()
    {
        return view('livewire.admin.component.typeroom-table');
    }
    public function add()
    {
        $this->validate();
        RoomType::create($this->type_room->pull());

        $this->type_rooms = RoomType::all();
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function delete()
    {
        $rt = RoomType::find($this->id);
        if ($rt) {
            $rt->delete();
            session()->flash('success', 'Record deleted successfully.');
        } else {
            session()->flash('error', 'Record deleted fail.');
        }
        $this->deleteId = null;
        $this->type_rooms = RoomType::all();
    }
}
