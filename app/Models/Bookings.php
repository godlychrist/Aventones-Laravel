<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Bookings extends Authenticatable
{
    use HasFactory, Notifiable;

    public $timestamps = false;

    // 👇 MUY IMPORTANTE: este modelo usa la tabla BOOKINGS
    protected $table = 'bookings';

    // 👇 Tu PK sigue siendo la misma
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'status',
        'ride_id',
        'date',
        'driver_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
