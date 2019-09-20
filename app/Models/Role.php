<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const ADMIN = 'ADMIN';
    const PROJECT_OWNER = 'PROJECT_OWNER';
    const PROJECT_USER = 'PROJECT_USER';
    const PROJECT_READER = 'PROJECT_READER';

    /**
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return self|null
     */
    public static function getAdminRole()
    {
        return self::where('type', self::ADMIN)->first();
    }

    /**
     * @return self|null
     */
    public static function getProjectOwnerRole()
    {
        return self::where('type', self::PROJECT_OWNER)->first();
    }

    /**
     * @return self|null
     */
    public static function getProjectUserRole()
    {
        return self::where('type', self::PROJECT_USER)->first();
    }

    /**
     * @return self|null
     */
    public static function getProjectReaderRole()
    {
        return self::where('type', self::PROJECT_READER)->first();
    }
}