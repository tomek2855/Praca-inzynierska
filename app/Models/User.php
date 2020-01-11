<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable;
    use HasApiTokens;

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'first_name', 'last_name', 'is_admin',
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
    public function projects()
    {
        return $this->belongsToMany(Project::class)->using(ProjectUser::class)->withTimestamps()->withPivot(['role', 'created_by', 'updated_by']);
    }

    /**
     * @return bool
     */
    public function isAdmin() : bool
    {
        return $this->is_admin;
    }

    /**
     * @return string
     */
    public function getFullName() : string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * @return self
     */
    public static function defaultUser()
    {
        $user = new self();
        $user->login = '';
        $user->first_name = '';
        $user->last_name = '';

        return $user;
    }
}
