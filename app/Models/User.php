<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'is_admin',
        'is_active',
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
            'is_admin' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function links()
    {
        return $this->hasMany(Link::class);
    }

    // Subscription relationship
    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }

    // Convenience accessor for current plan via subscription
    public function plan()
    {
        return $this->subscription ? $this->subscription->plan : null;
    }

    // Helper to check if user reached their link limit based on plan
    public function hasReachedLinkLimit(): bool
    {
        $plan = $this->plan();
        if (!$plan) {
            // Fallback to a default limit if no plan (should not happen)
            return $this->links()->count() >= 5;
        }
        return $this->links()->count() >= $plan->link_limit;
    }
}
