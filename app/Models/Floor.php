<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Floor
 *
 * Represents a floor in a building.
 *
 * @package App\Models
 */
class Floor extends Model
{
    protected $fillable = [
        'building_id',
        'floor_number',
        'floor_name',
        'total_units',
    ];

    // Relationships
    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function flats()
    {
        return $this->hasMany(Flat::class);
    }
}