<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_id',
        'balance',
    ];

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    public function paymentMethods()
    {
        return $this->hasMany(PaymentMethod::class);
    }

    public function movements()
    {
        return $this->hasMany(Movement::class);
    }
}
