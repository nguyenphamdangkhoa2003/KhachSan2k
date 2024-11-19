<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TypeRoomImage extends Model
{
    protected $fillable = [
        "room_type_id",
        "public_image_id",
        "url",
        "thumb"
    ];

    public function RoomType():BelongsTo {
        return $this->belongsTo(RoomType::class);
    }
}
