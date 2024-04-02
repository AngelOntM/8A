<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable //implements MustVerifyEmail
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
        'rol_id',
        'two_factor_code', 
        'two_factor_expires_at',
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
        'password' => 'hashed',
    ];

    public function chirps(): HasMany
    {
        return $this->hasMany(Chirp::class);
    }

    public function rol(): HasOne
    {
        return $this->hasOne(Rol::class);
    }

    public function generateTwoFactorCode(): void
    {
        $this->timestamps = false;  
        $this->two_factor_code = rand(100000, 999999);  
        $this->two_factor_expires_at = now()->addMinutes(10);  
        $this->save();
    }

    public function resetTwoFactorCode(): void
    {
        $this->timestamps = false;
        $this->two_factor_code = null;
        $this->two_factor_expires_at = null;
        $this->save();
    }

        public function generateThreeFactorCode(): void
    {
        $this->timestamps = false;  
        $this->three_factor_code = rand(100000, 999999);  
        $this->three_factor_expires_at = now()->addMinutes(10);  
        $this->save();
    }

        public function resetThreeFactorCode(): void
    {
        $this->timestamps = false;
        $this->three_factor_code = null;
        $this->three_factor_expires_at = null;
        $this->save();
    }
}
