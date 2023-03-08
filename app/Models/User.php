<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\User as UserRef;
use App\Models\Rules;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'promo_code',
        'rule_id',
        'ref_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['rule_name'];

    public function getRuleNameAttribute() {
        return $this->rule->name;
    }


    public function rule(): HasOne
    {
        return $this->hasOne(Rules::class, 'id', 'rule_id');
    }

    public function transaction(): HasOne
    {
        return $this->hasOne(Transaction::class, 'id', 'user_id');
    }

    public function user() {
        return $this->hasOne(\App\Models\User::class, 'id', 'ref_id')->where('ref_id', '>', 0);
    }
    

    
}
