<?php

namespace Database\Factories;

use App\Models\WeightTarget;
use Illuminate\Database\Eloquent\Factories\Factory;

class WeightTargetFactory extends Factory
{
    protected $model = WeightTarget::class;

    public function definition(): array
    {
        return [
            // user_id は Seeder 側で紐づける
            'target_weight' => $this->faker->randomFloat(1, 40, 120),
        ];
    }
}
