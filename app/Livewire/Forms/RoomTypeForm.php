<?php

namespace App\Livewire\Forms;

use App\Models\RoomType;
use Livewire\Attributes\Validate;
use Livewire\Form;

class RoomTypeForm extends Form
{
    #[Validate('required|string|max:255')]
    public $name;

    #[Validate('required|numeric|min:0')]
    public $price;

    #[Validate('required|integer|min:0')]
    public $adult;

    #[Validate('required|integer|min:0')]
    public $children;

    #[Validate('nullable|string|max:500')]
    public $description;
}
