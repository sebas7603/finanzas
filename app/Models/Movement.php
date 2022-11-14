<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    use HasFactory;

    protected $fillable = [
        'financial_id',
        'amount',
        'description',
        'income',
        'date',
        'category_id',
        'movement_type_id',
        'payment_method_id',
        'external_id',
        'payment_id',
        'account_id',
    ];

    public function financial()
    {
        return $this->belongsTo(Financial::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function movementType()
    {
        return $this->belongsTo(MovementType::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
    
    public function external()
    {
        return $this->belongsTo(External::class);
    }
    
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
