<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Livewire\WithFileUploads;

class RoomType extends Model
{
    use WithFileUploads;
    use HasFactory;
    protected $fillable = [
        "name",
        "adult",
        "children",
        "price",
        "description",
    ];
    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }
    public function TypeRoomImages(): HasMany
    {
        return $this->hasMany(TypeRoomImage::class);
    }
    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => number_format($value, 0, ',', '.') . ' VNĐ'
        );
    }
}
