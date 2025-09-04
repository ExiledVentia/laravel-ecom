<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status', // pending|paid|expired|failed
        'total_amount',
        'xendit_invoice_id',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'total_amount' => 'integer',
    ];

    // Relasi: order dimiliki oleh user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: order punya banyak items
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Scope untuk order yang sudah dibayar
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    // Helper: format total
    public function getTotalFormatAttribute()
    {
        return 'Rp ' . number_format($this->total_amount, 0, ',', '.');
    }
}
