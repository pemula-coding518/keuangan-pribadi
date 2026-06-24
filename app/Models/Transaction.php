<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /*
    |--------------------------------------------------------------------------
    | Nama tabel
    |--------------------------------------------------------------------------
    */

    protected $table = 'transactions';

    /*
    |--------------------------------------------------------------------------
    | Mass Assignment
    |--------------------------------------------------------------------------
    | Field yang boleh diisi
    */

    protected $fillable = [
        'title',
        'type',
        'category_id',
        'amount',
        'transaction_date',
        'description',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relasi ke kategori
    |--------------------------------------------------------------------------
    */

    public function category()
    {
        return $this->belongsTo(
            Category::class,
            'category_id',
            'id'
        );
    }
}