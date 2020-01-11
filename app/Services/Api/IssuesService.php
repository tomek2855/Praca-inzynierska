<?php

namespace App\Services\Api;

use App\Mail\AssigneIssueToUser;
use App\Models\Issue;
use App\Models\IssueFile;
use App\Models\User;
use App\Services\FilesService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class IssuesService
{
    protected $filesService;

    public function __construct(FilesService $filesService)
    {
        $this->filesService = $filesService;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function showUserIssues(Request $request)
    {
        if ($request->has('q') && !empty($request->get('q')))
        {
            $result = Issue::where('assigned_user_id', Auth::id())->where('title', 'LIKE', '%' . $request->get('q') . '%')->orderBy('project_id')->paginate(15);
        }
        else
        {
            $result = Issue::where('assigned_user_id', Auth::id())->orderBy('project_id')->paginate(15);
        }

        foreach ($result as &$item)
        {
            $item->statusText = $item->getStatus();
        }

        return $result;
    }

    /**
     * @param int $id
     * @return Issue|null
     */
    public function show(int $id) : ?Issue
    {
        try
        {
            $issue = Issue::with('files')->findOrFail($id);

            $issue->statusText = $issue->getStatus();

            return $issue;
        }
        catch (ModelNotFoundException $e)
        {
            return null;
        }
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Issue|null
     */
    public function update(Request $request, int $id) : ?Issue
    {
        try
        {
            $issue = Issue::findOrFail($id);

            $oldAssignedUserId = $issue->assigned_user_id;

            $issue->update($request->all());

            $newAssignedUserId = $issue->assigned_user_id;

            if ($oldAssignedUserId !== $newAssignedUserId)
            {
                $oldUser = User::find($oldAssignedUserId);
                $newUser = User::find($newAssignedUserId);

                if ($oldUser && !empty($oldUser->email))
                {
                    Mail::to($oldUser->email)->send(new AssigneIssueToUser($issue, $newUser ?? User::defaultUser()));
                }
                if ($newUser && !empty($newUser->email))
                {
                    Mail::to($newUser->email)->send(new AssigneIssueToUser($issue, $newUser));
                }
            }

            return $issue;
        }
        catch (ModelNotFoundException $e)
        {
            return null;
        }
    }

    /**
     * @param int $issueId
     * @return int
     */
    public function destroy(int $issueId) : int
    {
        return Issue::where('id', $issueId)->firstOrFail()->delete();
    }

    /**
     * @param Request $request
     * @param int $issueId
     * @return bool
     */
    public function addFileToIssue(Request $request, int $issueId) : bool
    {
        try
        {
            $fileId = $this->filesService->uploadFile($request);

            IssueFile::create([
                'issue_id' => $issueId,
                'file_id' => $fileId,
            ]);

            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    public function deleteFileFromIssue(Request $request, int $fileId, int $issueId)
    {

    }
}
