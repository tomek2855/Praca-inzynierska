<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Project\StoreProjectRequest;
use App\Services\Api\ProjectsService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ProjectsController extends Controller
{
    protected $projectsService;

    public function __construct(ProjectsService $projectsService)
    {
        $this->projectsService = $projectsService;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        return Response::create($this->projectsService->index($request));
    }

    /**
     * @param StoreProjectRequest $request
     * @return Response
     */
    public function store(StoreProjectRequest $request)
    {
        $result = $this->projectsService->store($request);

        return Response::create($result, Response::HTTP_CREATED);
    }

    /**
     * @param $id
     * @return Response
     */
    public function show($id)
    {
        $result = $this->projectsService->show($id);

        if ($result)
        {
            return Response::create($result);
        }

        return Response::create('', Response::HTTP_NOT_FOUND);
    }

    /**
     * @param StoreProjectRequest $request
     * @param $id
     * @return Response
     */
    public function update(StoreProjectRequest $request, $id)
    {
        $result = $this->projectsService->update($request, $id);

        if ($result)
        {
            return Response::create($this->projectsService->show($id));
        }

        return Response::create('', Response::HTTP_NOT_FOUND);
    }

    /**
     * @param $id
     * @return Response
     */
    public function destroy($id)
    {
        return Response::create($this->projectsService->destroy($id));
    }

    /**
     * @param $id
     * @return Response
     */
    public function getUserList($id)
    {
        return Response::create($this->projectsService->userList($id));
    }

    /**
     * @param $id
     * @return Response
     */
    public function getAssignedUsers($id)
    {
        return Response::create($this->projectsService->getAssignedUsers($id));
    }

    /**
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function postAssignedUsers(Request $request, $id)
    {
        return Response::create($this->projectsService->addAssignedUser($request, $id));
    }
}
