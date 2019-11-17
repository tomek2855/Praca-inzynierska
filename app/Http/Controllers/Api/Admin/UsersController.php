<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\Comment\UpdateCommentRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\AddUserRequest;
use App\Http\Requests\Admin\User\UpdateUserRequest;
use App\Services\Api\Admin\AdminService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UsersController extends Controller
{
    protected $adminService;

    /**
     * UsersController constructor.
     * @param AdminService $adminService
     */
    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $result = $this->adminService->getUsersList($request);

        return Response::create($result);
    }

    public function show(Request $request, int $id)
    {
        $result = $this->adminService->getUser($id);

        if ($result)
        {
            return Response::create($result);
        }

        return Response::create('', Response::HTTP_NOT_FOUND);
    }

    /**
     * @param int $id
     * @return Response
     */
    public function destroy(int $id)
    {
        $result = $this->adminService->deleteUser($id);

        if ($result)
        {
            return Response::create();
        }

        return Response::create('', Response::HTTP_BAD_REQUEST);
    }


    /**
     * @param UpdateUserRequest $request
     * @param int $id
     * @return Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $result = $this->adminService->updateUser($request, $id);

        if ($result)
        {
            return Response::create($this->adminService->getUser($id));
        }

        return Response::create('', Response::HTTP_NOT_FOUND);
    }

    /**
     * @param AddUserRequest $request
     * @return Response
     */
    public function store(AddUserRequest $request)
    {
        $result = $this->adminService->addUser($request);

        if ($result)
        {
            return Response::create($result);
        }

        return Response::create('', Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param int $id
     * @return Response
     */
    public function generateNewPass(int $id)
    {
        $result = $this->adminService->generateNewPassword($id);

        if ($result)
        {
            return Response::create('');
        }

        return Response::create('', Response::HTTP_NOT_FOUND);
    }
}
