<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// Import seeder
use Database\Seeders\CategorySeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Menjalankan CategorySeeder
        $this->call(CategorySeeder::class);
    }
}