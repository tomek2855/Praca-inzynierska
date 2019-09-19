<?php

namespace App\Observers;

use App\Models\File;
use Illuminate\Support\Facades\Auth;

class FileObserver
{
    /**
     * Handle the file "created" event.
     *
     * @param  \App\File  $file
     * @return void
     */
    public function created(File $file)
    {
        //
    }

    /**
     * Handle the file "creating" event.
     *
     * @param  \App\File  $file
     * @return void
     */
    public function creating(File $file)
    {
        $file->created_by = Auth::id() ?? 0;
        $file->updated_by = Auth::id() ?? 0;
    }

    /**
     * Handle the file "updated" event.
     *
     * @param  \App\File  $file
     * @return void
     */
    public function updated(File $file)
    {
        //
    }

    /**
     * Handle the file "updating" event.
     *
     * @param  \App\File  $file
     * @return void
     */
    public function updating(File $file)
    {
        $file->updated_by = Auth::id() ?? $file->updated_by;
    }

    /**
     * Handle the file "deleted" event.
     *
     * @param  \App\File  $file
     * @return void
     */
    public function deleted(File $file)
    {
        //
    }

    /**
     * Handle the file "restored" event.
     *
     * @param  \App\File  $file
     * @return void
     */
    public function restored(File $file)
    {
        //
    }

    /**
     * Handle the file "force deleted" event.
     *
     * @param  \App\File  $file
     * @return void
     */
    public function forceDeleted(File $file)
    {
        //
    }
}
