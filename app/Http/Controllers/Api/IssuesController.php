<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Issue\DeleteIssueRequest;
use App\Http\Requests\Issue\GetIssueRequest;
use App\Http\Requests\Issue\UpdateIssueRequest;
use App\Services\Api\IssuesService;
use App\Http\Controllers\Controller;
use App\Services\Api\ProjectIssuesService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class IssuesController extends Controller
{
    protected $issuesService;

    protected $projectIssuesService;

    /**
     * IssuesController constructor.
     * @param IssuesService $issuesService
     * @param ProjectIssuesService $projectIssuesService
     */
    public function __construct(IssuesService $issuesService, ProjectIssuesService $projectIssuesService)
    {
        $this->issuesService = $issuesService;
        $this->projectIssuesService = $projectIssuesService;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        return Response::create($this->issuesService->showUserIssues($request));
    }

    /**
     * @param GetIssueRequest $request
     * @param int $id
     * @return Response
     */
    public function show(GetIssueRequest $request, int $id)
    {
        $result = $this->issuesService->show($id);

        if ($result)
        {
            return Response::create($result);
        }

        return Response::create('', Response::HTTP_NOT_FOUND);
    }

    /**
     * @param UpdateIssueRequest $request
     * @param int $id
     * @return Response
     */
    public function update(UpdateIssueRequest $request, int $id)
    {
        $result = $this->issuesService->update($request, $id);

        if ($result)
        {
            return Response::create($this->issuesService->show($id));
        }

        return Response::create('', Response::HTTP_NOT_FOUND);
    }

    /**
     * @param DeleteIssueRequest $request
     * @param $issueId
     * @return Response
     */
    public function destroy(DeleteIssueRequest $request, $issueId)
    {
        return Response::create($this->issuesService->destroy($issueId));
    }
}
