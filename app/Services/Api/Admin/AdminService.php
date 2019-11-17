<?php

namespace App\Services\Api\Admin;

use App\Extensions\RoleResolver\UserProjectRoleResolver;
use App\Mail\NewUserPassword;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdminService
{
    public function getUsersList(Request $request)
    {
        if ($request->has('q') && !empty($request->get('q')))
        {
            $q = $request->get('q');

            return User::where('name', 'LIKE', '%' . $q . '%')
                ->orWhere('email', 'LIKE', '%' . $q . '%')
                ->orWhere('first_name', 'LIKE', '%' . $q . '%')
                ->orWhere('last_name', 'LIKE', '%' . $q . '%')
                ->paginate(15);
        }

        return User::paginate(15);
    }

    /**
     * @param integer $id
     * @return User|null
     */
    public function getUser(int $id) : ?User
    {
        try
        {
            $user = User::findOrFail($id);

            $user->projects = UserProjectRoleResolver::userProjectsList($user);

            return $user;
        }
        catch (ModelNotFoundException $e)
        {
            return null;
        }
    }

    /**
     * @param Request $request
     * @param integer $id
     * @return User|null
     */
    public function updateUser(Request $request, int $id) : ?User
    {
        try
        {
            $user = User::findOrFail($id);
            $user->update($request->all());

            return $user;
        }
        catch (ModelNotFoundException $e)
        {
            return null;
        }
    }

    /**
     * @param Request $request
     * @return User|null
     */
    public function addUser(Request $request) : ?User
    {
        try
        {
            $password = Str::random(8);

            $user = User::create($request->all() + [
                'password' => \Hash::make($password)
            ]);

            $user->save();

            Mail::to($user->email)->send(new NewUserPassword($password));

            return $user;
        }
        catch (\Exception $e)
        {
            return null;
        }
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteUser(int $id) : bool
    {
        try
        {
            return User::findOrFail($id)->delete();
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    /**
     * @param int $id
     */
    public function generateNewPassword(int $id) : bool
    {
        try
        {
            $password = Str::random(8);

            $user = User::findOrFail($id);

            $user->password = \Hash::make($password);

            $user->save();

            Mail::to($user->email)->send(new NewUserPassword($password));

            return true;
        }
        catch (\Exception $e)
        {
            return false;
        }
    }
}
