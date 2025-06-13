<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = array(
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    );

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = array(
        'name',
        'email',
        'password',
    );

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = array(
        'password',
        'remember_token',
    );

    public function aisleItems(): HasMany
    {
        return $this->hasMany(AisleItem::class);
    }

    public function aisles(): HasMany
    {
        return $this->hasMany(Aisle::class);
    }

    public function groceryLists(): HasMany
    {
        return $this->hasMany(GroceryList::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }
    public function stores(): HasMany
    {
        return $this->hasMany(Store::class);
    }
}
