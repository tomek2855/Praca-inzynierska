<?php

namespace App\Models;

use App\Models\Interfaces\AuditableInterface;
use App\Models\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model implements AuditableInterface
{
    use AuditableTrait;
    use SoftDeletes;

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
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function issue()
    {
        return $this->hasOne(Issue::class);
    }
}