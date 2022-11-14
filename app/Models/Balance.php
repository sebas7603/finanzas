<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    use HasFactory;

    protected $fillable = [
        'financial_id',
        'incomed_money',
        'outcomed_money',
        'balance',
        'date',
    ];

    public function financial()
    {
        return $this->belongsTo(Financial::class);
    }
}
