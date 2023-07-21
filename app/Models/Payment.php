<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'day',
        'payment_method_id',
        'debt_id',
        'subscription_id',
        'card_id',
    ];

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function debt()
    {
        return $this->belongsTo(Debt::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function Card()
    {
        return $this->belongsTo(Card::class);
    }

    public function movements()
    {
        return $this->hasMany(Movement::class);
    }
}
