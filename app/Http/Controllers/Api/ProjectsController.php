<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Project\AddUserToProjectRequest;
use App\Http\Requests\Project\DeleteProjectRequest;
use App\Http\Requests\Project\DeleteUserToProjectRequest;
use App\Http\Requests\Project\GetProjectRequest;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Services\Api\ProjectsService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

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
     * @param GetProjectRequest $request
     * @param $id
     * @return Response
     */
    public function show(GetProjectRequest $request, $id)
    {
        $result = $this->projectsService->show($id);

        if ($result)
        {
            return Response::create($result);
        }

        return Response::create('', Response::HTTP_NOT_FOUND);
    }

    /**
     * @param UpdateProjectRequest $request
     * @param $id
     * @return Response
     */
    public function update(UpdateProjectRequest $request, $id)
    {
        $result = $this->projectsService->update($request, $id);

        if ($result)
        {
            return Response::create($this->projectsService->show($id));
        }

        return Response::create('', Response::HTTP_NOT_FOUND);
    }

    /**
     * @param DeleteProjectRequest $request
     * @param $id
     * @return Response
     */
    public function destroy(DeleteProjectRequest $request, $id)
    {
        return Response::create($this->projectsService->destroy($id));
    }

    /**
     * @param GetProjectRequest $request
     * @param $id
     * @return Response
     */
    public function getUserList(GetProjectRequest $request, $id)
    {
        return Response::create($this->projectsService->userList($id));
    }

    /**
     * @param GetProjectRequest $request
     * @param $id
     * @return Response
     */
    public function getAssignedUsers(GetProjectRequest $request, $id)
    {
        return Response::create($this->projectsService->getAssignedUsers($id));
    }

    /**
     * @param AddUserToProjectRequest $request
     * @param $id
     * @return Response
     */
    public function postAssignedUsers(AddUserToProjectRequest $request, $id)
    {
        return Response::create($this->projectsService->addAssignedUser($request, $id));
    }

    /**
     * @param DeleteUserToProjectRequest $request
     * @param $id
     * @return Response
     */
    public function deleteAssignedUsers(DeleteUserToProjectRequest $request, $id)
    {
        return Response::create($this->projectsService->deleteAssignedUser($request, $id));
    }
}
