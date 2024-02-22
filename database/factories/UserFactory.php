<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\EmailQueue;

class EmailQueueFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EmailQueue::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'linkable_id' => $this->faker->randomNumber(),
            'linkable_type' => $this->faker->word,
            'subject' => $this->faker->sentence,
            'email' => $this->faker->safeEmail,
            'view' => $this->faker->word,
            'params' => json_encode($this->faker->words(3)), // asumiendo que params es un array de palabras
            'status' => $this->faker->randomElement(['pending', 'processing', 'completed', 'failed']),
            'created_at' => $this->faker->dateTime,
            'updated_at' => $this->faker->dateTime,
            'sent' => $this->faker->optional()->dateTime,
            'attempt' => $this->faker->numberBetween(0, 5)
        ];
    }
}
