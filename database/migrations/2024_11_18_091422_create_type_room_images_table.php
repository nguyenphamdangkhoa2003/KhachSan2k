<?php

use App\Models\RoomType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('type_room_images', function (Blueprint $table) {
            $table->id();
            $table->text(column: "url");
            $table->string("public_image_id");
            $table->foreignIdFor(RoomType::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->tinyInteger("thumb")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_room_images');
    }
};
