<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\File\StoreFileRequest;
use App\Services\FilesService;
use Illuminate\Http\Response;

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
     * @param StoreFileRequest $request
     * @return Response
     */
    public function store(StoreFileRequest $request)
    {
        $result = $this->filesService->uploadFile($request);

        if ($result)
        {
            return Response::create(['id' => $result], Response::HTTP_CREATED);
        }

        return Response::create('', Response::HTTP_BAD_REQUEST);
    }
}