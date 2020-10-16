<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the wallets.
     */
    public function wallets()
    {
        return $this->hasMany('App\Models\Wallet');
    }

    /**
     * Get the active wallets.
     */
    public function getActiveWalletsAttribute()
    {
        return $this->wallets()->where('used', false);
    }

    /**
     * Get the number of active wallets.
     */
    public function getActiveWalletsCountAttribute()
    {
        return $this->active_wallets->count();
    }

    /**
     * Get the one of active wallets.
     */
    public function getActiveWalletAttribute()
    {
        return $this->active_wallets->first();
    }
}
