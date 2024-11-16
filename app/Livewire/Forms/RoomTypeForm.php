<?php

namespace App\Livewire\Forms;

use App\Models\RoomType;
use Livewire\Attributes\Validate;
use Livewire\Form;

class RoomTypeForm extends Form
{
    public $name;
    public $price;
    public $adult;
    public $children;
    public $description;


    // Quy tắc xác thực
    protected $rules = [
        'name' => 'required|string|max:255',           // Tên phòng là bắt buộc, chuỗi, tối đa 255 ký tự
        'price' => 'required|numeric|min:0',           // Giá là bắt buộc, phải là số, không âm
        'adult' => 'required|integer|min:1',           // Số người lớn là bắt buộc, số nguyên, ít nhất 1
        'children' => 'required|integer|min:1',        // Số trẻ em không bắt buộc, số nguyên, ít nhất 0
        'description' => 'nullable|string|max:500',    // Mô tả không bắt buộc, chuỗi, tối đa 500 ký tự
    ];
}
