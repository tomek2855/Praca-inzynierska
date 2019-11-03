<?php

namespace App\Services;


use App\Extensions\RoleResolver\UserFileRoleResolver;
use App\Extensions\StorageFile\StorageFile;
use App\Models\File;
use App\Models\FilesUsage;
use App\Models\Project;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FilesService
{
    /**
     * @param int $id
     * @return File|bool|null
     */
    public function getFile(int $id)
    {
        try
        {
            $file = File::findOrFail($id);

            if (UserFileRoleResolver::canDownload(Auth::user(), $file))
            {
                return $file;
            }

            return false;
        }
        catch (ModelNotFoundException $e)
        {
            return null;
        }
    }

    /**
     * @param Request $request
     * @return int|null
     */
    public function uploadFile(Request $request) : ?int
    {
        try
        {
            if (filter_var($request->get('isPublic'), FILTER_VALIDATE_BOOLEAN))
            {
                $sf = new StorageFile('public');
            }
            else
            {
                $sf = new StorageFile('local');
            }

            return $sf->add($request->allFiles()['file'])->id;
        }
        catch (\Exception $e)
        {
            return null;
        }
    }

    /**
     * @param int $fileId
     * @return Project|null
     */
    public function getProjectByFile(int $fileId) : ?Project
    {
        $project = FilesUsage::where('file_id', $fileId)->first()->project;

        if ($project)
        {
            return $project;
        }

        return null;
    }
}