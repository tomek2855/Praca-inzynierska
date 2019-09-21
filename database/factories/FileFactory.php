<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\File;
use Faker\Generator as Faker;
use Illuminate\Http\UploadedFile;
use \Illuminate\Support\Facades\Storage;

$factory->define(File::class, function (Faker $faker) {
    Storage::fake('local');

    $fakeFile = UploadedFile::fake()->create('test.txt');

    return [
        'driver' => 'local',
        'path' => $fakeFile->getPathname(),
        'filename' => $fakeFile->getBasename(),
        'mime_type' => $fakeFile->getMimeType(),
    ];
});
