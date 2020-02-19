<?php

namespace App\Models;

use App\Models\Interfaces\AuditableInterface;
use App\Models\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Issue extends Model implements AuditableInterface
{
    use AuditableTrait;
    use SoftDeletes;

    const STATUS_NEW = 0;
    const STATUS_IN_PROGRESS = 1;
    const STATUS_ENDED = 2;
    const STATUS_CLOSED = 3;
    const STATUS_REJECTED = 4;

    /**
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'title',
        'content',
        'terminated',
        'project_id',
        'assigned_user_id',
        'status',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function project()
    {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function assignedUser()
    {
        return $this->hasOne(User::class, 'id', 'assigned_user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function files()
    {
        return $this->belongsToMany(File::class, 'issue_file')->using(IssueFile::class)->with('user');
    }

    /**
     * @return string
     */
    public function getStatus() : string
    {
        $status = '';

        switch ($this->status)
        {
            case self::STATUS_NEW:
                $status = 'Nowy';
                break;
            case self::STATUS_IN_PROGRESS:
                $status = 'W trakcie realizacji';
                break;
            case self::STATUS_ENDED:
                $status = 'Zakończony';
                break;
            case self::STATUS_CLOSED:
                $status = 'Zamknięty';
                break;
            case self::STATUS_REJECTED:
                $status = 'Odrzucony';
                break;
        }

        return $status;
    }
}
