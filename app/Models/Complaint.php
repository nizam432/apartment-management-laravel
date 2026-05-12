<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Complaint
 *
 * Represents a complaint submitted by a tenant.
 *
 * @package App\Models
 */
class Complaint extends Model
{
    protected $fillable = [
        'admin_id', 'building_id', 'flat_id', 'tenant_id',
        'subject', 'description', 'status', 'admin_note',
    ];

    public function admin()    { return $this->belongsTo(User::class, 'admin_id'); }
    public function building() { return $this->belongsTo(Building::class); }
    public function flat()     { return $this->belongsTo(Flat::class); }
    public function tenant()   { return $this->belongsTo(Tenant::class); }
}