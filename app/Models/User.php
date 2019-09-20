<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id')->using(UserRoles::class)->withTimestamps();
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->roles()->where('role_id', Role::getAdminRole()->id)->whereNull('project_id')->exists();
    }

    /**
     * @param bool $admin
     */
    public function setAdmin($admin = true)
    {
        if (!$this->isAdmin() && $admin)
        {
            $this->roles()->attach(Role::getAdminRole(), ['project_id' => null]);
        }
        else if ($this->isAdmin() && !$admin)
        {
            $this->roles()->detach(Role::getAdminRole());
        }
    }
}
