<?php

namespace App\Models;

use App\Models\Interfaces\AuditableInterface;
use App\Models\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProjectUser extends Pivot implements AuditableInterface
{
    use AuditableTrait;

    const PROJECT_OWNER = 'PROJECT_OWNER';
    const PROJECT_MODERATOR = 'PROJECT_MODERATOR';
    const PROJECT_USER = 'PROJECT_USER';
    const PROJECT_READER = 'PROJECT_READER';

    /**
     * @var array
     */
    protected $guarded = [
        'project_id',
        'user_id',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
