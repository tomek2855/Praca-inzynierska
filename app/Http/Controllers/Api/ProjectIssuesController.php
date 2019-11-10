<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Issue\StoreIssueRequest;
use App\Http\Requests\Issue\UpdateIssueRequest;
use App\Services\Api\ProjectIssuesService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ProjectIssuesController extends Controller
{
    protected $projectIssuesService;

    public function __construct(ProjectIssuesService $projectIssuesService)
    {
        $this->projectIssuesService = $projectIssuesService;
    }

    /**
     * @param Request $request
     * @param int $projectId
     * @return Response
     */
    public function index(Request $request, int $projectId)
    {
        $result = $this->projectIssuesService->index($request, $projectId);

        if ($result)
        {
            return Response::create($result);
        }

        return Response::create('', Response::HTTP_NOT_FOUND);
    }

    /**
     * @param StoreIssueRequest $request
     * @param int $projectId
     * @return Response
     */
    public function store(StoreIssueRequest $request, int $projectId)
    {
        $result = $this->projectIssuesService->store($request, $projectId);

        if ($result)
        {
            return Response::create($result, Response::HTTP_CREATED);
        }

        return Response::create('', Response::HTTP_NOT_FOUND);
    }

    /**
     * @param $projectId
     * @param $issueId
     * @return Response
     */
    public function show($projectId, $issueId)
    {
        $result = $this->projectIssuesService->show($projectId, $issueId);

        if ($result)
        {
            return Response::create($result);
        }

        return Response::create('', Response::HTTP_NOT_FOUND);
    }

    /**
     * @param UpdateIssueRequest $request
     * @param $projectId
     * @param $issueId
     * @return Response
     */
    public function update(UpdateIssueRequest $request, $projectId, $issueId)
    {
        $result = $this->projectIssuesService->update($request, $projectId, $issueId);

        if ($result)
        {
            return Response::create($this->projectIssuesService->show($projectId, $issueId));
        }

        return Response::create('', Response::HTTP_NOT_FOUND);
    }
}
