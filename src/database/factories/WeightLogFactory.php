<?php

namespace Database\Factories;

use App\Models\WeightLog;
use Illuminate\Database\Eloquent\Factories\Factory;

class WeightLogFactory extends Factory
{
    protected $model = WeightLog::class;

    public function definition(): array
    {
        // 日付は過去〜最近あたりで適当に
        $date = $this->faker->dateTimeBetween('-60 days', 'now')->format('Y-m-d');

        // exercise_minutes は 0〜180分ぐらい
        $exerciseMinutes = $this->faker->numberBetween(0, 180);

        return [
            
            'date' => $date,
            'weight' => $this->faker->randomFloat(1, 40, 120), // 1桁小数
            'calories' => $this->faker->numberBetween(800, 2500),
            'exercise_minutes' => $exerciseMinutes,

        
            'exercise_content' => $this->faker->optional()->realText(60),
        ];
    }
}
