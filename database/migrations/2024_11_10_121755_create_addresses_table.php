<?php

use App\Models\Address;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string("province");
            $table->string("district");
            $table->string("ward");
            $table->timestamps();
        });
        Schema::table("users", function (Blueprint $table) {
            $table->foreignIdFor(Address::class)->nullable()->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("users", function (Blueprint $table) {
            $table->dropForeignIdFor(Address::class);
        });
        Schema::dropIfExists('addresses');
    }
};
