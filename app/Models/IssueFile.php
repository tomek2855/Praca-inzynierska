<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class IssueFile extends Pivot
{
    /**
     * @var array
     */
    protected $primaryKey = ['issue_id', 'file_id'];

    /**
     * @var string
     */
    protected $table = 'issue_file';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function file()
    {
        return $this->hasOne(File::class, 'id', 'file_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function issue()
    {
        return $this->hasOne(Issue::class, 'id', 'issue_id');
    }
}
