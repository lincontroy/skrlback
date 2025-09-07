<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class User extends Authenticatable
{
    use HasFactory, Notifiable,HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'pin',
        'customer_id',
        'skiller_badge',
        'biometrics_enabled',
        'notifications_enabled',
        'balance',
        'currency',
    ];

    protected $hidden = [
        'pin',
        'remember_token',
    ];

    protected $casts = [
        'biometrics_enabled' => 'boolean',
        'notifications_enabled' => 'boolean',
        'balance' => 'decimal:2',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // Generate a unique customer ID
    public static function generateCustomerId()
    {
        $prefix = 'SKR';
        $timestamp = now()->format('ymd');
        $random = strtoupper(substr(uniqid(), -4));
        
        return $prefix . $timestamp . $random;
    }

    // Update user balance
    public function updateBalance($amount, $type)
    {
        if ($type === 'deposit') {
            $this->balance += $amount;
        } elseif ($type === 'withdrawal') {
            $this->balance -= $amount;
        }
        
        $this->save();
    }
}