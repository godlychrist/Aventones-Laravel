<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ride extends Model
{
    use HasFactory;

    public $timestamps = false; 
    protected $table = 'rides';       

    protected $fillable = [
        'name',
        'origin',
        'destination',
        'date',
        'time',
        'space_cost',
        'space',
        'user_id',
        'vehicle_id',     
        'status'
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id', 'cedula');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'plateNum');
    }
}
