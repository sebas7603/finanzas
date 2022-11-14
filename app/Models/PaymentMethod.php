<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'account_id',
        'card_id',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function card()
    {
        return $this->belongsTo(Card::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function movements()
    {
        return $this->hasMany(Movement::class);
    }
}
