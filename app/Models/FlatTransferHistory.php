<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FlatTransferHistory
 *
 * Tracks tenant flat transfers within the same building.
 *
 * @package App\Models
 */
class FlatTransferHistory extends Model
{
    protected $fillable = [
        'tenant_id',
        'building_id',
        'from_flat_id',
        'to_flat_id',
        'from_floor_id',
        'to_floor_id',
        'old_rent',
        'new_rent',
        'transfer_date',
        'reason',
        'created_by',
    ];

    protected $casts = [
        'transfer_date' => 'date',
    ];

    // Relationships
    public function tenant()    { return $this->belongsTo(Tenant::class); }
    public function building()  { return $this->belongsTo(Building::class); }
    public function fromFlat()  { return $this->belongsTo(Flat::class, 'from_flat_id'); }
    public function toFlat()    { return $this->belongsTo(Flat::class, 'to_flat_id'); }
    public function fromFloor() { return $this->belongsTo(Floor::class, 'from_floor_id'); }
    public function toFloor()   { return $this->belongsTo(Floor::class, 'to_floor_id'); }
    public function createdBy() { return $this->belongsTo(User::class, 'created_by'); }
}