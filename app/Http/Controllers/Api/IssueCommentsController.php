<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Services\Api\CommentsService;
use Illuminate\Http\Response;

class IssueCommentsController extends Controller
{
    protected $commentsService;

    /**
     * IssueCommentsController constructor.
     * @param CommentsService $commentsService
     */
    public function __construct(CommentsService $commentsService)
    {
        $this->commentsService = $commentsService;
    }

    /**
     * @param int $issueId
     * @return Response
     */
    public function getIssueComments(int $issueId)
    {
        $result = $this->commentsService->showIssueComments($issueId);

        if ($result)
        {
            return Response::create($result);
        }

        return Response::create('', Response::HTTP_NOT_FOUND);
    }

    /**
     * @param StoreCommentRequest $request
     * @param int $issueId
     * @return Response
     */
    public function addIssueComment(StoreCommentRequest $request, int $issueId)
    {
        $result = $this->commentsService->addCommentToIssue($request, $issueId);

        if ($result)
        {
            return Response::create($result, Response::HTTP_CREATED);
        }

        return Response::create('', Response::HTTP_BAD_REQUEST);
    }
}