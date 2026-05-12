<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Notice
 *
 * Represents a notice/announcement for tenants, owners or employees.
 *
 * @package App\Models
 */
class Notice extends Model
{
    protected $fillable = [
        'admin_id', 'building_id', 'title', 'body', 'target', 'expire_date',
    ];

    protected $casts = [
        'expire_date' => 'date',
    ];

    public function admin()    { return $this->belongsTo(User::class, 'admin_id'); }
    public function building() { return $this->belongsTo(Building::class); }
}