<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'avatar',
        'scans_used',
        'matches_used',
        'hives_used',
        'usage_reset_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'usage_reset_at' => 'datetime',
        ];
    }

    public function scans()
    {
        return $this->hasMany(Scan::class);
    }

    public function collab()
    {
        return $this->hasOne(Collab::class);
    }

    public function checkLimit($feature)
    {
        // Subscribers have unlimited access
        if ($this->subscribed('default')) {
            return true;
        }

        // Reset usage if needed (monthly)
        if ($this->usage_reset_at && $this->usage_reset_at->lt(now()->startOfMonth())) {
            $this->update([
                'scans_used' => 0,
                'matches_used' => 0,
                'hives_used' => 0,
                'usage_reset_at' => now(),
            ]);
        } elseif (!$this->usage_reset_at) {
            $this->update(['usage_reset_at' => now()]);
        }

        $limits = [
            'scans' => 5,
            'matches' => 5,
            'hives' => 5,
        ];

        $usageKey = $feature . '_used';
        return $this->$usageKey < ($limits[$feature] ?? 0);
    }

    public function incrementUsage($feature)
    {
        if ($this->subscribed('default')) {
            return;
        }
        $usageKey = $feature . '_used';
        $this->increment($usageKey);
    }
}
