<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Kategori Pemasukan
        |--------------------------------------------------------------------------
        */

        Category::create([
            'name' => 'Gaji',
            'type' => 'income'
        ]);

        Category::create([
            'name' => 'Bonus',
            'type' => 'income'
        ]);

        Category::create([
            'name' => 'Freelance',
            'type' => 'income'
        ]);

        Category::create([
            'name' => 'Investasi',
            'type' => 'income'
        ]);

        /*
        |--------------------------------------------------------------------------
        | Kategori Pengeluaran
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

        Category::create([
            'name' => 'Belanja',
            'type' => 'expense'
        ]);

        Category::create([
            'name' => 'Tagihan',
            'type' => 'expense'
        ]);

        /*
        |--------------------------------------------------------------------------
        | Kategori Lainnya
        |--------------------------------------------------------------------------
        */

         Category::create([
            'name' => 'Lainnya',
            'type' => 'other'
        ]);

       
    }
}