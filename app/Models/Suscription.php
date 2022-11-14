<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'amount',
        'day',
        'month',
        'category_id',
        'external_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function external()
    {
        return $this->belongsTo(External::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
