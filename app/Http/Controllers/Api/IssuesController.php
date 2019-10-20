<?php

namespace App\Http\Controllers\Api;

use App\Services\Api\IssuesService;
use App\Http\Controllers\Controller;
use App\Services\Api\ProjectIssuesService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

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
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        $result = $this->issuesService->show($id);

        if ($result)
        {
            return Response::create($result);
        }

        return Response::create('', Response::HTTP_NOT_FOUND);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, int $id)
    {
        $result = $this->issuesService->update($request, $id);

        if ($result)
        {
            return Response::create($this->issuesService->show($id));
        }

        return Response::create('', Response::HTTP_NOT_FOUND);
    }
}
