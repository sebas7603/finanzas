<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Model
{
    use HasFactory, HasUlids, SoftDeletes;

    protected $fillable = [
        'bank_id',
        'account_id',
        'card_type_id',
        'last_numbers',
        'quota',
        'amount',
        'fee',
        'balance_day',
        'payment_day',
    ];

    protected $hidden = [
        'financial_id',
        'bank_id',
        'account_id',
        'card_type_id',
    ];

    protected $casts = [
        'quota' => 'numeric',
        'amount' => 'numeric',
        'fee' => 'numeric',
        'balance_day' => 'numeric',
        'payment_day' => 'numeric',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
        'deleted_at' => 'timestamp',
    ];

    /**
     * Eloquent Relationships
     */

    public function financial()
    {
        return $this->belongsTo(Financial::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
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
