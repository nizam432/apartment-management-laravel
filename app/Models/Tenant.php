<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Tenant
 *
 * Represents a tenant living in a flat.
 *
 * @package App\Models
 */
class Tenant extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'admin_id',
        'building_id',
        'floor_id',
        'flat_id',
        'name',
        'phone',
        'email',
        'permanent_address',
        'date_of_birth',
        'gender',
        'profession',
        'emergency_contact_name',
        'emergency_contact_phone',
        'nid_front',
        'nid_back',
        'picture',
        'notes',
        'monthly_rent',
        'advance_amount',
        'move_in_date',
        'move_out_date',
        'status',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'move_in_date'  => 'date',
        'move_out_date' => 'date',
    ];

    // Relationships
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function floor()
    {
        return $this->belongsTo(Floor::class);
    }

    public function flat()
    {
        return $this->belongsTo(Flat::class);
    }

    public function documents()
    {
        return $this->hasMany(TenantDocument::class);
    }
}