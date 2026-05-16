<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class RentAmountHistory
 *
 * Tracks rent amount changes over time for each tenant/flat.
 *
 * @package App\Models
 */
class RentAmountHistory extends Model
{
    protected $fillable = [
        'flat_id',
        'tenant_id',
        'created_by',
        'old_amount',
        'new_amount',
        'effective_from',
        'reason',
    ];

    protected $casts = [
        'effective_from' => 'date',
    ];

    // Relationships
    public function flat()
    {
        return $this->belongsTo(Flat::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the effective rent amount for a tenant on a given date.
     * Returns the latest rent amount that was effective on or before the given date.
     *
     * @param int $tenantId
     * @param string $date (Y-m-d format)
     * @return float|null
     */
    public static function getEffectiveRent(int $tenantId, string $date): ?float
    {
        $history = self::where('tenant_id', $tenantId)
                       ->where('effective_from', '<=', $date)
                       ->latest('effective_from')
                       ->first();

        if ($history) {
            return $history->new_amount;
        }

        // If no history, return current monthly_rent from tenant
        return Tenant::find($tenantId)?->monthly_rent;
    }
}