<?php

namespace App\Models;

use App\Models\Interfaces\AuditableInterface;
use App\Models\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model implements AuditableInterface
{
    use AuditableTrait;

    /**
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    /**
     * @return bool|null
     * @throws \Exception
     */
    public function delete()
    {
        $storage = Storage::disk($this->driver);
        $storage->delete($this->path);

        return parent::delete();
    }

    /**
     * @return string
     */
    public function getFullFilePath() : string
    {
        $path = config('filesystems.disks')[$this->driver]['root'];
        $path .= '/' . $this->path;

        return $path;
    }
}
