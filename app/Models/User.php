<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Laravel\Cashier\Billable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, Billable;

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new \App\Notifications\VerifyEmail);
    }

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
        'trial_ends_at',
        'daily_tokens_remaining',
        'last_token_reset_at',
        'is_admin',
        'ip_address',
        'country',
        'admin_notes',
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
            'trial_ends_at' => 'datetime',
            'last_token_reset_at' => 'datetime',
            'is_admin' => 'boolean',
        ];
    }

    protected static function booted()
    {
        static::created(function ($user) {
            // Give 7 days trial
            $user->trial_ends_at = now()->addDays(7);
            $user->save();
        });
    }

    public function scans()
    {
        return $this->hasMany(Scan::class);
    }

    public function collab()
    {
        return $this->hasOne(Collab::class);
    }
    
    public function onTrial()
    {
        return $this->trial_ends_at && $this->trial_ends_at->isFuture();
    }

    public function checkLimit()
    {
        // Subscribers have unlimited access
        if ($this->subscribed('default')) {
            return true;
        }

        // Trial users have unlimited access
        if ($this->onTrial()) {
            return true;
        }

        // Daily Reset Logic
        if (!$this->last_token_reset_at || $this->last_token_reset_at->lt(now()->startOfDay())) {
            $this->update([
                'daily_tokens_remaining' => 15,
                'last_token_reset_at' => now(),
            ]);
            return true;
        }

        return $this->daily_tokens_remaining > 0;
    }

    public function consumeToken()
    {
        if ($this->subscribed('default')) {
            return;
        }

        if ($this->onTrial()) {
            return;
        }

        // Ensure we drag the reset logic here too
        if (!$this->last_token_reset_at || $this->last_token_reset_at->lt(now()->startOfDay())) {
             $this->update([
                'daily_tokens_remaining' => 14, // 15 - 1
                'last_token_reset_at' => now(),
            ]);
        } else {
            $this->decrement('daily_tokens_remaining');
        }
    }
}
