<?php

namespace Database\Factories;

use App\Models\EmailQueue;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmailQueueFactory extends Factory
{
    protected $model = EmailQueue::class;

    public function sent()
    {
        return $this->state(function (array $attributes) {
            return [
                'attempt' => $this->faker->numberBetween(1, 5),
                'status'  => 'completed',
                'sent'    => $this->faker->dateTimeThisMonth(),
            ];
        });
    }

    public function failed()
    {
        return $this->state(function (array $attributes) {
            return [
                'attempt' => 5,
                'status'  => 'failed',
                'sent'    => null,
            ];
        });
    }

    public function pending()
    {
        return $this->state(function (array $attributes) {
            return [
                'attempt' => 0,
                'status'  => 'pending',
                'sent'    => null,
            ];
        });
    }

    public function definition()
    {
        $date = $this->faker->dateTimeThisMonth();

        return [
            'linkable_id'   => $this->faker->randomNumber(),
            'linkable_type' => $this->faker->randomElement(['App\\Contact', 'App\\Policie']),
            'subject'       => $this->faker->sentence,
            'email'         => $this->faker->unique()->safeEmail,
            'view'          => $this->faker->randomElement(['default', 'payment_failed', 'change_password']),
            'params'        => json_encode(['name' => $this->faker->name]),
            'created_at'    => $date,
            'updated_at'    => $date,
        ];
    }
}
