<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'card_type_id',
        'quota',
        'amount',
        'fee',
        'balance_day',
        'payment_day',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function cardType()
    {
        return $this->belongsTo(CardType::class);
    }

    public function paymentMethods()
    {
        return $this->hasMany(PaymentMethod::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
