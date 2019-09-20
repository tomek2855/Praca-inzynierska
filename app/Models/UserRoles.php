<?php

namespace App\Models;

use App\Models\Interfaces\AuditableInterface;
use App\Models\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserRoles extends Pivot implements AuditableInterface
{
    use AuditableTrait;

    /**
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }
}
