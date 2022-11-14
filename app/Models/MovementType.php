<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovementType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function movements()
    {
        return $this->hasMany(Movement::class);
    }
}
