<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use HasFactory, HasUlids, SoftDeletes;

    protected $fillable = [
        'description',
        'amount',
        'day',
        'month',
        'category_id',
        'external_id',
    ];

    protected $hidden = [
        'financial_id',
        'category_id',
        'external_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'day' => 'integer',
        'month' => 'integer',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
        'deleted_at' => 'timestamp',
    ];

    /**
     * Eloquent Relationships
     */

    public function financial()
    {
        return $this->belongsTo(Financial::class);
    }

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
