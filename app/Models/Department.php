<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Department
 *
 * Represents an employee department (Security, Cleaning, etc.)
 * Created by Super Admin.
 *
 * @package App\Models
 */
class Department extends Model
{
    protected $fillable = [
        'name',
        'created_by',
    ];

    // Relationships
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}