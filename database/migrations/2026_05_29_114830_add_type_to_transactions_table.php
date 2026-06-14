<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Jalankan migration
     */
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {

            // Menambahkan kolom type
            $table->string('type')->after('title');

        });
    }

    /**
     * Rollback migration
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {

            // Menghapus kolom type
            $table->dropColumn('type');

        });
    }

};