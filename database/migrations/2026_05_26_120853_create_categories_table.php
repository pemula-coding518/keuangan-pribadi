<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /*
    |--------------------------------------------------------------------------
    | Method up()
    |--------------------------------------------------------------------------
    | Digunakan untuk membuat tabel
    |
    */

    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {

            // Primary Key / ID otomatis
            $table->id();

            // Nama kategori
            // Contoh:
            // Gaji
            // Bonus
            // Makanan
            $table->string('name');

            /*
            |--------------------------------------------------------------------------
            | Jenis kategori
            |--------------------------------------------------------------------------
            | income  = pemasukan
            | expense = pengeluaran
            |
            */

            $table->enum('type', ['income', 'expense']);

            // created_at & updated_at
            $table->timestamps();
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Method down()
    |--------------------------------------------------------------------------
    | Digunakan saat rollback migration
    |
    */

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};