<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class RentPayment
 *
 * Represents a rent payment record for a tenant.
 *
 * @package App\Models
 */
class RentPayment extends Model
{
    protected $fillable = [
        'admin_id',
        'building_id',
        'flat_id',
        'tenant_id',
        'month',
        'rent_amount',
        'paid_amount',
        'due_amount',
        'paid_date',
        'payment_method',
        'transaction_id',
        'note',
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