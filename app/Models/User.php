<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nik',
        'name',
        'email',
        'phone',
        'address',
        'role',
        'is_verified',
        'password',
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
            'is_verified' => 'boolean',
        ];
    }

    /**
     * Check if user is admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is warga.
     */
    public function isWarga(): bool
    {
        return $this->role === 'warga';
    }

    /**
     * Check if user account is verified.
     */
    public function isVerified(): bool
    {
        return $this->is_verified;
    }

    /**
     * Get the letter requests for the user.
     */
    public function letterRequests(): HasMany
    {
        return $this->hasMany(LetterRequest::class);
    }

    /**
     * Get the complaints for the user.
     */
    public function complaints(): HasMany
    {
        return $this->hasMany(Complaint::class);
    }

    /**
     * Get the dues for the user.
     */
    public function dues(): HasMany
    {
        return $this->hasMany(Due::class);
    }
}
