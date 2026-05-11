<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Owner
 *
 * Represents an owner of one or more flats.
 *
 * @package App\Models
 */
class Owner extends Model
{
    protected $fillable = [
        'user_id',
        'admin_id',
        'nid_number',
        'nid_front',
        'nid_back',
        'picture',
        'present_address',
        'permanent_address',
        'payment_info',
        'notes',
        'status',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function flats()
    {
        return $this->hasMany(Flat::class, 'owner_id', 'user_id');
    }
}