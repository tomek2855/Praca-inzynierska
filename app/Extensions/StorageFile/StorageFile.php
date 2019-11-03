<?php

namespace App\Extensions\StorageFile;

use App\Models\File;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class StorageFile
{
    private $driver;

    private $storage;

    public function __construct($driver = 'public')
    {
        if (!array_key_exists($driver, config('filesystems.disks')))
        {
            throw new \Exception('Storage driver named "' . $driver . '" does not exists');
        }

        $this->driver = $driver;
        $this->storage = Storage::disk($driver);
    }

    public function add(UploadedFile $uploadedFile) : File
    {
        $now = Carbon::now();
        $path = $now->format('Y/m/d');
        $filePath = $this->storage->put($path, $uploadedFile);

        $file = new File();
        $file->driver = $this->driver;
        $file->path = $filePath;
        $file->filename = basename($filePath);
        $file->original_filename = $uploadedFile->getClientOriginalName();
        $file->mime_type = $uploadedFile->getClientMimeType();
        $file->save();

        return $file;
    }
}