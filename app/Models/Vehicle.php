<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    public $timestamps = false;           // tu tabla no tiene created_at/updated_at
    protected $table = 'vehicles';        // nombre real de la tabla

    protected $fillable = [
        'plateNum',
        'color',
        'brand',
        'model',
        'year',
        'image',
        'user_id',     // 👈 aquí va la cédula del usuario dueño
        'capacity',
    ];

    // Relación con el usuario (usa cedula como PK)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'cedula');
    }
}
