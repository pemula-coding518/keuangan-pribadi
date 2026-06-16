<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

   public function up(): void
{
    Schema::create('categories', function (Blueprint $table) {

        $table->id();

        // Nama kategori
        $table->string('name');

        // Income / Expense
        $table->enum('type', [
            'income',
            'expense',
            'other'
        ]);

        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {

            $table->dropColumn('category');

        });
    }
};