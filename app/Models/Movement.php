<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Movement extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'movements';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'date',
        'leavePlace',
        'destinationPlace',
        'resultsNum',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the user that performed the search.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'cedula');
    }
}
