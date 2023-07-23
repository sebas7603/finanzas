<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Financial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'day',
        'user_id',
    ];

    protected $hidden = [
        'user_id',
    ];

    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function balances()
    {
        return $this->hasMany(Balance::class);
    }

    public function lastBalance()
    {
        return $this->hasOne(Balance::class)->latest();
    }

    public function movements()
    {
        return $this->hasMany(Movement::class)->orderBy('created_at', 'desc');
    }
}
