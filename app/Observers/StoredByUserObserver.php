<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;

class StoredByUserObserver
{
    /**
     * @param Object $object
     */
    public function created(Object $object)
    {
        //
    }

    /**
     * @param Object $object
     */
    public function creating(Object $object)
    {
        $object->created_by = Auth::id() ?? null;
        $object->updated_by = Auth::id() ?? null;
    }

    /**
     * @param Object $object
     */
    public function updated(Object $object)
    {
        //
    }

    /**
     * @param Object $object
     */
    public function updating(Object $object)
    {
        $object->updated_by = Auth::id() ?? $object->updated_by;
    }

    /**
     * @param Object $object
     */
    public function deleted(Object $object)
    {
        //
    }

    /**
     * @param Object $object
     */
    public function restored(Object $object)
    {
        //
    }

    /**
     * @param Object $object
     */
    public function forceDeleted(Object $object)
    {
        //
    }
}
