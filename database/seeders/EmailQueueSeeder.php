<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmailQueue;

class EmailQueueSeeder extends Seeder
{
    public function run()
    {
        EmailQueue::factory()->count(50)->create();
    }
}