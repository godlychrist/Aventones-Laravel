<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Driver extends Authenticatable
{
    use HasFactory, Notifiable;

    public $timestamps = false;

    // 👇 MUY IMPORTANTE: este modelo usa la tabla USERS
    protected $table = 'users';

    // 👇 Tu PK sigue siendo la misma
    protected $primaryKey = 'cedula';

    protected $fillable = [
        'cedula',
        'name',
        'lastname',
        'birthDate',
        'email',
        'phoneNum',
        'password',
        'image',
        'state',
        'userType',
        'token',
        'expiration_token',
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
