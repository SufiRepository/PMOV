<?php

namespace App\Observers;

use App\Models\Actionlog;
use App\Models\Project;
use Auth;

class ProjectObserve
{
    /**
     * Listen to the User created event.
     *
     * @param  Project  $project
     * @return void
     */
    public function updated(Project $project)
    {

        $logAction = new Actionlog();
        $logAction->item_type = Project::class;
        $logAction->item_id = $project->id;
        $logAction->created_at =  date("Y-m-d H:i:s");
        $logAction->user_id = Auth::id();
        $logAction->logaction('update');
    }


    /**
     * Listen to the project created event when
     * a new license is created.
     *
     * @param  Project  $project
     * @return void
     */
    public function created(Project $project)
    {

        $logAction = new Actionlog();
        $logAction->item_type = Project::class;
        $logAction->item_id = $project->id;
        $logAction->created_at =  date("Y-m-d H:i:s");
        $logAction->user_id = Auth::id();
        $logAction->logaction('create');

    }

    /**
     * Listen to the Project deleting event.
     *
     * @param  Project  $project
     * @return void
     */
    public function deleting(Project $project)
    {
        $logAction = new Actionlog();
        $logAction->item_type = Project::class;
        $logAction->item_id = $project->id;
        $logAction->created_at =  date("Y-m-d H:i:s");
        $logAction->user_id = Auth::id();
        $logAction->logaction('delete');
    }
}
