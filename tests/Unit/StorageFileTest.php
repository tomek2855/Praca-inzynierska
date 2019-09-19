<?php

namespace Tests\Unit;

use App\Extensions\StorageFile\StorageFile;
use App\Models\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StorageFileTest extends TestCase
{
    public function testAddFileTest()
    {
        Storage::fake('local');

        $storageFile = new StorageFile('local');
        $file = $storageFile->add(UploadedFile::fake()->image('test.jpg'));

        $this->assertInstanceOf(File::class, $file);
        Storage::disk('local')->assertExists($file->path);
    }
}