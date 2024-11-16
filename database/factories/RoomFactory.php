<?php

namespace Database\Factories;

use App\Models\RoomType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'room_number' => $this->faker->countryCode(),
            'area' => $this->faker->numberBetween(20, 100),                // Diện tích ngẫu nhiên từ 20 đến 100
            'quanlity' => $this->faker->numberBetween(1, 10),              // Số lượng phòng ngẫu nhiên từ 1 đến 10
            'description' => $this->faker->sentence(10),                   // Mô tả ngẫu nhiên với 10 từ
            'status' => $this->faker->randomElement(['available', 'booked', 'fixing']),  // Trạng thái ngẫu nhiên
            'room_type_id' => $this->faker->randomElement(RoomType::all('id')),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
