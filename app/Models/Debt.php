<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Debt extends Model
{
    use HasFactory, HasUlids, SoftDeletes;

    protected $fillable = [
        'description',
        'amount',
        'fee_value',
        'fee_day',
        'fee_number',
        'fee_current',
        'status',
        'category_id',
        'external_id',
        'bank_id',
    ];

    protected $hidden = [
        'financial_id',
        'category_id',
        'external_id',
        'bank_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'fee_value' => 'decimal:2',
        'fee_day' => 'integer',
        'fee_number' => 'integer',
        'fee_current' => 'integer',
        'status' => 'integer',
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

    public function bank()
    {
        $this->belongsTo(Bank::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
