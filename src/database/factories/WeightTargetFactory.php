<?php

namespace Database\Factories;

use App\Models\WeightTarget;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class WeightTargetFactory extends Factory
{
    /**
     * Define the model's default state.
     * @var string

     * @return array
     */
    protected $model = WeightTarget::class;

    public function definition()
    {
        $user = User::first() ?? User::factory()->create();

        return [
            'user_id' => $user->id,
            'target_weight' => $this->faker->randomFloat(1, 45, 65),
        ];
    }
}
