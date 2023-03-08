<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Commission extends Model
{
    use HasFactory;

    
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'trans_id', 'id');
    }

    
}
