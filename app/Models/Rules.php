<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rules extends Model
{
    use HasFactory;

    public const ADMIN = 1;
    public const AFFILIATE = 2;
    public const SUBAFFILIATE = 3;
    public const NORMALUSER = 4;

    protected $fillable = [
        'name'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
