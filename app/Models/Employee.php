<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Employee
 *
 * Represents an employee (security guard, caretaker, etc.)
 *
 * @package App\Models
 */
class Employee extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'admin_id',
        'building_id',
        'department_id',
        'employee_code',
        'name',
        'phone',
        'email',
        'photo',
        'designation',
        'salary',
        'join_date',
        'resign_date',
        'employment_status',
        'work_shift',
        'present_address',
        'permanent_address',
        'nid_number',
        'emergency_contact_name',
        'emergency_contact_phone',
        'payment_info',
    ];

    protected $casts = [
        'join_date'   => 'date',
        'resign_date' => 'date',
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

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function documents()
    {
        return $this->hasMany(EmployeeDocument::class);
    }

    /**
     * Auto generate employee code.
     * Format: EMP-0001
     */
    public static function generateCode(): string
    {
        $last = self::withTrashed()->latest('id')->first();
        $num  = $last ? $last->id + 1 : 1;
        return 'EMP-' . str_pad($num, 4, '0', STR_PAD_LEFT);
    }
}