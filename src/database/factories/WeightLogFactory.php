<?php

namespace Database\Factories;

use App\Models\WeightLog;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use App\Models\User;


class WeightLogFactory extends Factory
{
    protected $model = WeightLog::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function configure()
    {
        $dateCounter = 0;

        return $this->afterMaking(function (WeightLog $log) use (&$dateCounter) {
            $log->date = now()->subDays($dateCounter++)->format('Y-m-d');
        });
    }

    public function definition()
    {
        $user = User::first();

        $date = $this->faker->dateTimeBetween('-35 days', 'now')->format('Y-m-d');

        $weight = $this->faker->randomFloat(1, 45.0, 55.0);
        $calories = $this->faker->numberBetween(100, 250) * 10;
        $hour = $this->faker->numberBetween(0, 2);
        $minute = $this->faker->numberBetween(0, 59);
        $exercise_time = sprintf('%02d:%02d:00', $hour, $minute);

        return [
            'user_id' => $user->id,
            'date' => $date,
            'weight' => $weight,
            'calories' => $calories,
            'exercise_time' => $exercise_time,
            'exercise_content' => $this->faker->sentence(5),
        ];
    }
}
