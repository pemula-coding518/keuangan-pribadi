<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /*
    |--------------------------------------------------------------------------
    | Membuat tabel transactions
    |--------------------------------------------------------------------------
    */

    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {

            // Primary key
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Foreign Key
            |--------------------------------------------------------------------------
            | Menghubungkan transactions dengan categories
            |
            */

            $table->foreignId('category_id')
                ->constrained()
                ->onDelete('cascade');

            // Judul transaksi
            $table->string('title');

            // Jumlah uang
            $table->decimal('amount', 15, 2);

            // Deskripsi transaksi
            $table->text('description')->nullable();

            // Tanggal transaksi
            $table->date('transaction_date');

            // created_at & updated_at
            $table->timestamps();
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Menghapus tabel saat rollback
    |--------------------------------------------------------------------------
    */

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};