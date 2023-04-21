<?php

namespace Database\Seeders;

use App\Models\Local;
use Database\Factories\LocalFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Local::factory()->count(15)->create();
    }
}
