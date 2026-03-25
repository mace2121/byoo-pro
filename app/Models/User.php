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
        'verified',
        'google_id',
        'provider',
        'avatar',
        'plan',
        'plan_expire_date',
        'is_verified',
        'onboarding_completed',
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
            'plan_expire_date' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'is_active' => 'boolean',
            'verified' => 'boolean',
            'is_verified' => 'boolean',
            'onboarding_completed' => 'boolean',
        ];
    }

    public function isPro()
    {
        return $this->is_admin || $this->plan === 'pro';
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function links()
    {
        return $this->hasMany(Link::class);
    }

    public function blocks()
    {
        return $this->hasMany(Block::class);
    }

    // Subscription relationship
    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }

    public function personalThemes()
    {
        return $this->hasMany(Theme::class);
    }

    // Convenience accessor for current plan via subscription
    public function activePlan()
    {
        return $this->subscription ? $this->subscription->plan : null;
    }

    public function canAccess(string $feature): bool
    {
        if ($this->isPro()) {
            return true;
        }

        $restricted = [
            'product',
            'custom_theme',
            'custom_css',
            'verified'
        ];

        return !in_array($feature, $restricted, true);
    }

    public function hasPremiumAccess(): bool
    {
        return $this->is_admin || $this->isPro();
    }

    public function canUseProductBlocks(): bool
    {
        return $this->canAccess('product');
    }

    public function canCustomizeTheme(): bool
    {
        return $this->canAccess('custom_theme');
    }

    public function canUseAnalytics(): bool
    {
        // Analytics can be restricted later
        return $this->hasPremiumAccess();
    }

    public function canUseVerifiedBadge(): bool
    {
        return $this->canAccess('verified');
    }

    public function canUseScheduling(): bool
    {
        return $this->isPro();
    }

    // Helper to check if user reached their link limit based on plan
    public function hasReachedLinkLimit(): bool
    {
        if ($this->isPro()) {
            return false;
        }

        return $this->links()->count() >= 5;
    }

    // Helper to generate WhatsApp upgrade URL
    public function getUpgradeUrl(): string
    {
        $phone = env('WHATSAPP_UPGRADE_NUMBER', '905555555555');
        $message = "Merhaba, Pro üyelik almak istiyorum. Kullanıcı adım: " . $this->username;
        return "https://wa.me/{$phone}?text=" . urlencode($message);
    }
}
