<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TenantDocument
 *
 * Represents a document attached to a tenant.
 *
 * @package App\Models
 */
class TenantDocument extends Model
{
    protected $fillable = [
        'tenant_id',
        'document_name',
        'file_path',
    ];

    // Relationships
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}