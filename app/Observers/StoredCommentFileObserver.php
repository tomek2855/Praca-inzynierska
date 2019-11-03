<?php

namespace App\Observers;

use App\Models\Comment;
use App\Models\FilesUsage;

class StoredCommentFileObserver
{
    /**
     * @param Comment $comment
     */
    public function created(Comment $comment)
    {
        if ($comment->file_id)
        {
            FilesUsage::create([
                'file_id' => $comment->file_id,
                'project_id' => $comment->issue->project->id,
            ]);
        }
    }
}
