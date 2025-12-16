<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $guarded = ['id']; // Semua kolom boleh diisi kecuali ID

    // Relasi: Bank milik satu User (EO)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}