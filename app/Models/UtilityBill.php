<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UtilityBill
 *
 * Represents a utility bill (water, electricity, other) for a flat.
 *
 * @package App\Models
 */
class UtilityBill extends Model
{
    protected $fillable = [
        'admin_id',
        'building_id',
        'flat_id',
        'tenant_id',
        'month',
        'water_bill',
        'electricity_bill',
        'previous_reading',
        'current_reading',
        'unit_used',
        'rate_per_unit',
        'other_bill',
        'other_bill_title',
        'total_amount',
        'status',
        'paid_date',
        'payment_method',
    ];

    protected $casts = [
        'paid_date' => 'date',
    ];

    // Relationships
    public function admin()    { return $this->belongsTo(User::class, 'admin_id'); }
    public function building() { return $this->belongsTo(Building::class); }
    public function flat()     { return $this->belongsTo(Flat::class); }
    public function tenant()   { return $this->belongsTo(Tenant::class); }
}