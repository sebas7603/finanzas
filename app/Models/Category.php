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

    public function movements()
    {
        return $this->hasMany(Movement::class);
    }
}
