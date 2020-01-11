<?php

namespace App\Observers;

use App\Models\FilesUsage;
use App\Models\IssueFile;

class StoredIssueFileObserver
{
    /**
     * @param ProjectFile $project
     */
    public function created(IssueFile $issueFile)
    {
        FilesUsage::create([
            'file_id' => $issueFile->file_id,
            'project_id' => $issueFile->issue->project_id,
        ]);
    }
}
