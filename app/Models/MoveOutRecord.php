<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MoveOutRecord extends Model
{
    protected $fillable = [
        'tenant_id',
        'flat_id',
        'floor_id',
        'building_id',
        'advance_paid',
        'amount_returned',
        'deduction',
        'deduction_reason',
        'move_out_date',
        'reason',
        'created_by',
    ];

    protected $casts = [
        'move_out_date'   => 'date',
        'advance_paid'    => 'decimal:2',
        'amount_returned' => 'decimal:2',
        'deduction'       => 'decimal:2',
    ];

    public function tenant()    { return $this->belongsTo(Tenant::class); }
    public function flat()      { return $this->belongsTo(Flat::class); }
    public function floor()     { return $this->belongsTo(Floor::class); }
    public function building()  { return $this->belongsTo(Building::class); }
    public function createdBy() { return $this->belongsTo(User::class, 'created_by'); }
}