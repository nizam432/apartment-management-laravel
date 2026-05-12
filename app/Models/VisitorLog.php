<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class VisitorLog
 *
 * Represents a visitor entry log.
 *
 * @package App\Models
 */
class VisitorLog extends Model
{
    protected $fillable = [
        'admin_id', 'building_id', 'flat_id', 'tenant_id', 'employee_id',
        'visitor_name', 'visitor_phone', 'purpose', 'in_time', 'out_time', 'note',
    ];

    protected $casts = [
        'in_time'  => 'datetime',
        'out_time' => 'datetime',
    ];

    public function admin()    { return $this->belongsTo(User::class, 'admin_id'); }
    public function building() { return $this->belongsTo(Building::class); }
    public function flat()     { return $this->belongsTo(Flat::class); }
    public function tenant()   { return $this->belongsTo(Tenant::class); }
    public function employee() { return $this->belongsTo(Employee::class); }
}