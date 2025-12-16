<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    // Pastikan semua kolom ini didaftarkan agar bisa di-isi (Mass Assignment)
    protected $fillable = [
        'title',
        'description',
        'event_date',
        'location',
        'quota',
        'price',
        'banner',
        'user_id',    // ID milik EO
        'category_id',
        'status',
    ];

    // Relasi: Event ini milik satu User (EO)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Event ini masuk kategori apa
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}