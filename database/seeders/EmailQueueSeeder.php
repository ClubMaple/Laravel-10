<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmailQueue;

class EmailQueueSeeder extends Seeder
{
    public function run()
    {
        EmailQueue::factory()->sent()->count(20)->create();
        EmailQueue::factory()->failed()->count(10)->create();
        EmailQueue::factory()->pending()->count(5)->create();
    }
}