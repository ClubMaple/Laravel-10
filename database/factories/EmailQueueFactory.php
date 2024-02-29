<?php

namespace Database\Factories;

use App\Models\EmailQueue;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmailQueueFactory extends Factory
{
    protected $model = EmailQueue::class;

    public function definition()
    {
        return [
            'linkable_id' => $this->faker->randomNumber(),
            'linkable_type' => $this->faker->word,
            'subject' => $this->faker->sentence,
            'email' => $this->faker->unique()->safeEmail,
            'view' => 'emails.' . $this->faker->word,
            'params' => json_encode($this->faker->words(3)),
            'status' => $this->faker->randomElement(['pending', 'processing', 'completed', 'failed']),
            'created_at' => $this->faker->dateTimeThisMonth(),
            'updated_at' => $this->faker->dateTimeThisMonth(),
            'sent' => $this->faker->boolean ? $this->faker->dateTimeThisMonth() : null,
            'attempt' => $this->faker->numberBetween(0, 5)
        ];
    }
}
