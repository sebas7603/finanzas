<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bank extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'picture',
    ];

    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    /**
     * Eloquent Relationships
     */

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    public function debts()
    {
        return $this->hasMany(Debt::class);
    }
}
