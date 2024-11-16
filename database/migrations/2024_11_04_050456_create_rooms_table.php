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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string("room_number");
            $table->integer("area");
            $table->integer('quanlity');
            $table->string('description');
            $table->foreignIdFor(RoomType::class)->constrained()->onDelete('cascade');  // Khóa ngoại tới bảng room_types
            $table->enum('status', ['available', 'booked', 'fixing']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
