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

    protected $hidden = [
        'user_id',
    ];

    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    /**
     * Eloquent Relationships
     */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

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
