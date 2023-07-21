<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class External extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'picture',
    ];

    public function debts()
    {
        return $this->hasMany(Debt::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function movements()
    {
        return $this->hasMany(Movement::class);
    }
}
