<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Comment\UpdateCommentRequest;
use App\Services\Api\CommentsService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommentsController extends Controller
{
    protected $commentsService;

    /**
     * CommentsController constructor.
     * @param CommentsService $commentsService
     */
    public function __construct(CommentsService $commentsService)
    {
        $this->commentsService = $commentsService;
    }

    /**
     * @param int $id
     * @return Response
     */
    public function destroy(int $id)
    {
        $result = $this->commentsService->deleteComment($id);

        if ($result)
        {
            return Response::create();
        }

        return Response::create('', Response::HTTP_BAD_REQUEST);
    }


    /**
     * @param UpdateCommentRequest $request
     * @param int $id
     * @return Response
     */
    public function update(UpdateCommentRequest $request, int $id)
    {
        $result = $this->commentsService->updateComment($request, $id);

        if ($result)
        {
            return Response::create($this->commentsService->show($id));
        }

        return Response::create('', Response::HTTP_NOT_FOUND);
    }
}
