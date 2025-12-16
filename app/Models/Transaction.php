<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'payment_proof',
        'status',
    ];

    // Relasi: Transaksi milik siapa?
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Transaksi untuk event apa?
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}