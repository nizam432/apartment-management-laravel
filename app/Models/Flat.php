<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Flat
 *
 * Represents a flat/unit in a building floor.
 *
 * @package App\Models
 */
class Flat extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'building_id',
        'floor_id',
        'owner_id',
        'flat_number',
        'flat_type',
        'size_sqft',
        'rent_amount',
        'water_bill_applicable',
        'water_bill_amount',
        'electricity_type',
        'electricity_meter_no',
        'status',
    ];

    protected $casts = [
        'water_bill_applicable' => 'boolean',
    ];

    // Relationships
    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function floor()
    {
        return $this->belongsTo(Floor::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function tenant()
    {
        return $this->hasOne(Tenant::class)->where('status', 'active');
    }
}