<?php

namespace App\Extensions\RoleResolver;


use App\Models\File;
use App\Models\User;
use App\Services\FilesService;

class UserFileRoleResolver
{
    /**
     * @param User|null $user
     * @param File $file
     * @return bool
     */
    public static function canDownload(?User $user, File $file) : bool
    {
        if ($file->driver == 'public')
        {
            return true;
        }
        else if ($file->driver == 'local' && !$user)
        {
            return false;
        }
        else if ($file->driver == 'local' && $user)
        {
            $service = new FilesService();
            $projectFile = $service->getProjectByFile($file->id);

            if (!$projectFile)
            {
                return false;
            }

            if ($user->is_admin)
            {
                return true;
            }

            return UserProjectRoleResolver::projectUsersList($projectFile)->pluck('id')->contains($user->id);
        }

        return false;
    }
}
