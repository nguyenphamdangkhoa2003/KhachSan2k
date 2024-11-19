<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;
    protected $fillable = [
        'room_number',
        'area',
        'quanlity',
        'description',
        'status',
        'room_type_id'
    ];
    public function roomType(): BelongsTo
    {
        return $this->belongsTo(RoomType::class);
    }
}
