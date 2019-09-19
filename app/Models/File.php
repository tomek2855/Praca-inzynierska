<?php

namespace App\Models;

use App\Models\Interfaces\AuditableInterface;
use App\Models\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Model;

class File extends Model implements AuditableInterface
{
    use AuditableTrait;

    /**
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * @var array
     */
    protected $attributes = [
        'permanently_deleted' => false,
    ];

}
