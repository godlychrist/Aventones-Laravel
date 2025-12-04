<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class LoginToken extends Model
{
    protected $fillable = [
        'email',
        'token',
        'used',
        'expires_at',
    ];

    protected $casts = [
        'used' => 'boolean',
        'expires_at' => 'datetime',
    ];

    /**
     * Generate a new login token for the given email
     */
    public static function generateToken(string $email): self
    {
        // Invalidate any existing unused tokens for this email
        self::where('email', $email)
            ->where('used', false)
            ->update(['used' => true]);

        // Create new token
        return self::create([
            'email' => $email,
            'token' => Str::random(64),
            'used' => false,
            'expires_at' => Carbon::now()->addMinutes(15), // Token expires in 15 minutes
        ]);
    }

    /**
     * Check if token is valid
     */
    public function isValid(): bool
    {
        return !$this->used && $this->expires_at->isFuture();
    }

    /**
     * Mark token as used
     */
    public function markAsUsed(): void
    {
        $this->update(['used' => true]);
    }
}
