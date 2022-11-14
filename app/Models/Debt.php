<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'amount',
        'fee_value',
        'fee_day',
        'fee_number',
        'fee_current',
        'status',
        'category_id',
        'external_id',
        'bank_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function external()
    {
        return $this->belongsTo(External::class);
    }

    public function bank()
    {
        $this->belongsTo(Bank::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
