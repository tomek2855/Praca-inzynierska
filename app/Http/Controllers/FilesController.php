<?php

namespace App\Http\Controllers;

use App\Services\FilesService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class FilesController extends Controller
{
    protected $filesService;

    /**
     * FilesController constructor.
     * @param FilesService $filesService
     */
    public function __construct(FilesService $filesService)
    {
        $this->filesService = $filesService;
    }

    /**
     * @param int $fileId
     * @param int|null $height
     * @param int|null $weight
     * @return Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download(int $fileId, ?int $height = null, ?int $weight = null)
    {
        $result = $this->filesService->getFile($fileId);

        if ($result === null)
        {
            return Response::create('', Response::HTTP_UNAUTHORIZED);
        }
        else if ($result === false)
        {
            return Response::create('', Response::HTTP_NOT_FOUND);
        }

        return response()->download($result->getFullFilePath(), $result->original_filename, ['filename' => $result->original_filename]);
    }
}
