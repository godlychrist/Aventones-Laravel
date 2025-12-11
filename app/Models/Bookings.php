<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Bookings extends Authenticatable
{
    use HasFactory, Notifiable;

    // Enable only created_at timestamp
    const UPDATED_AT = null;

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
        'created_at',
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
            'created_at' => 'datetime',
        ];
    }

    /**
     * Relación con el chofer (driver)
     */
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id', 'cedula');
    }

    /**
     * Relación con el pasajero (user)
     */
    public function passenger()
    {
        return $this->belongsTo(User::class, 'user_id', 'cedula');
    }

    /**
     * Relación con el viaje (ride)
     */
    public function ride()
    {
        return $this->belongsTo(Ride::class, 'ride_id', 'id');
    }
}
