<?php

namespace App\Models;

use App\Models\Interfaces\AuditableInterface;
use App\Models\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model implements AuditableInterface
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->using(ProjectUser::class)->withTimestamps()->withPivot(['role', 'created_by', 'updated_by']);
    }

    /**
     * @return User|null
     */
    public function getOwner()
    {
        return $this->users()->where('role', ProjectUser::PROJECT_OWNER)->first();
    }
}
