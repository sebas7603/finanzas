<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'icon',
    ];

    public function debts()
    {
        return $this->hasMany(Debt::class);
    }

    public function suscriptions()
    {
        return $this->hasMany(Suscription::class);
    }

    public function movements()
    {
        return $this->hasMany(Movement::class);
    }
}
