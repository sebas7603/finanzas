<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory, HasUlids, SoftDeletes;

    protected $fillable = [
        'bank_id',
        'number',
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
