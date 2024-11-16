<?php

namespace App\Livewire\Forms;

use Livewire\Form;

class RoomForm extends Form
{
    public $room_number;
    public $area;
    public $quanlity;
    public $description;
    public $status;
    public $room_type_id;

    // Quy tắc xác thực
    protected $rules = [
        'room_number' => 'required|string',
        'area' => 'required|numeric',
        'quanlity' => 'required|integer|min:1|max:5',
        'description' => 'nullable|string|max:500',
        'status' => 'required|in:available,booked,fixing',
        'room_type_id' => 'required|exists:room_types,id',
    ];
}
