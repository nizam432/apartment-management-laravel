<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Building
 *
 * Represents a building managed by an admin.
 *
 * @package App\Models
 */
class Building extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'admin_id',
        'name',
        'address',
        'city',
        'area',
        'total_floors',
        'total_units',
        'electricity_type',
        'water_bill_applicable',
        'water_bill_amount',
        'image',
        'description',
        'status',
    ];

    protected $casts = [
        'water_bill_applicable' => 'boolean',
    ];

    // Relationships
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function floors()
    {
        return $this->hasMany(Floor::class);
    }

    public function flats()
    {
        return $this->hasMany(Flat::class);
    }

    public function tenants()
    {
        return $this->hasMany(Tenant::class);
    }
}