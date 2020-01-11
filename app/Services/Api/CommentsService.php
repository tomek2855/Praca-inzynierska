<?php

namespace App\Services\Api;

use App\Mail\NewCommentInIssue;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CommentsService
{
    /**
     * @param int $commentId
     * @return Comment|null
     */
    public function show(int $commentId) : ?Comment
    {
        try
        {
            $comment = Comment::findOrFail($commentId);

            return $comment;
        }
        catch (ModelNotFoundException $e)
        {
            return null;
        }
    }

    /**
     * @param int $issueId
     * @return Collection|null
     */
    public function showIssueComments(int $issueId) : ?Collection
    {
        try
        {
            $comments = Comment::where('issue_id', $issueId)->with(['user', 'file'])->get();

            return $comments;
        }
        catch (ModelNotFoundException $e)
        {
            return null;
        }
    }

    /**
     * @param Request $request
     * @param int $issueId
     * @return Comment|null
     */
    public function addCommentToIssue(Request $request, int $issueId) : ?Comment
    {
        try
        {
            $comment = Comment::create($request->only(['content', 'file_id']) + ['issue_id' => $issueId]);

            if (!empty($comment->issue->assignedUser->email))
            {
                Mail::to($comment->issue->assignedUser->email)->send(new NewCommentInIssue($comment->issue, $comment));
            }

            return $comment;
        }
        catch (\Exception $e)
        {
            return null;
        }
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function deleteComment(int $id)
    {
        return Comment::findOrFail($id)->delete();
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Comment|null
     */
    public function updateComment(Request $request, int $id) : ?Comment
    {
        try
        {
            $issue = Comment::findOrFail($id);
            $issue->update($request->only(['content']));

            return $issue;
        }
        catch (ModelNotFoundException $e)
        {
            return null;
        }
    }
}
