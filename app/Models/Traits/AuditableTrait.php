<?php

namespace App\Models\Traits;


use App\Models\User;
use Illuminate\Support\Facades\Schema;

trait AuditableTrait
{
    public function createdBy()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function updatedBy()
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }

    public function deletedBy()
    {
        if (!Schema::hasColumn($this->getTable(), 'deleted_by'))
        {
            return null;
        }

        return $this->hasOne(User::class, 'id', 'deleted_by');
    }
}