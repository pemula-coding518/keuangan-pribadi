<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /*
    |--------------------------------------------------------------------------
    | Fillable
    |--------------------------------------------------------------------------
    | Data yang boleh diisi
    |
    */

    protected $fillable = [
        'name',
        'type'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relasi One To Many
    |--------------------------------------------------------------------------
    | Satu kategori memiliki banyak transaksi
    |
    */

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}