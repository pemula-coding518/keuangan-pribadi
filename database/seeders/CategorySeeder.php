<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// Import model Category
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /*
    |--------------------------------------------------------------------------
    | Menjalankan Seeder
    |--------------------------------------------------------------------------
    */

    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Data kategori pemasukan
        |--------------------------------------------------------------------------
        */

        Category::create([

            // Nama kategori
            'name' => 'Gaji',

            // Jenis kategori
            'type' => 'income'
        ]);

        Category::create([
            'name' => 'Bonus',
            'type' => 'income'
        ]);

        /*
        |--------------------------------------------------------------------------
        | Data kategori pengeluaran
        |--------------------------------------------------------------------------
        */

        Category::create([
            'name' => 'Makanan',
            'type' => 'expense'
        ]);

        Category::create([
            'name' => 'Transportasi',
            'type' => 'expense'
        ]);
    }
}