<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'trx_id',
        'trans_type',
        'amount',
        'with_id',
        'created_at',
        'updated_at'
    ];

    
    public function commission(): HasMany
    {
        return $this->hasMany(Commission::class, 'id', 'trans_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
