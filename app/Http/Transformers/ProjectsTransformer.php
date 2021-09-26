<?php
namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\Models\Project;
use App\Models\User;
Use App\Models\Company;
use App\Models\Contractor;
use Gate;
use Illuminate\Support\Facades\Storage;

use Illuminate\Database\Eloquent\Collection;

class ProjectsTransformer
{

    public function transformProjects (Collection $projects, $total)
    {
        $array = array();
        foreach ($projects as $project) {
            $array[] = self::transformProject($project);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformProject (Project $project)
    {
        $array = [
            'id'            => (int) $project->id,
            'name'          => e($project->name),
            'details'       => e($project->details),
            'costing'       => e($project->costing),
            'value'         => Helper::formatCurrencyOutput($project->value,'value'),
            'duration'      => e($project->duration),
            'projectnumber' => e($project->projectnumber),

            'image' =>   ($project->image) ? Storage::disk('public')->url('projects/'.e($project->image)) : null,
            'end_date'      => Helper::getFormattedDateObject($project->end_date, 'date'),
            'start_date'    => Helper::getFormattedDateObject($project->start_date, 'date'),
            'finish_date'      => Helper::getFormattedDateObject($project->finish_date, 'finish_date'),

            'location'      => e($project->location)    ? ['id' => (int) $project  -> location      ->   id, 'name'  => e($project->location->name)] : null,
            'user'          => e($project->user)        ? ['id' => (int) $project  -> user          ->   id, 'name'  => e($project->user->getFullNameAttribute())] : null,
            'company'       => e($project->company)     ? ['id' => (int) $project  -> company       ->   id, 'name'  => e($project->company->name)] : null,
            'client'        => e($project->client)      ? ['id' => (int) $project  -> client        ->   id, 'name'  => e($project->client->name)] : null,

            
            'contractor'    => e($project->contractor)  ? ['id' => (int) $project  -> contractor    ->   id, 'name'  => e($project->contractor->name)] : null,
            'typeproject'   => e($project->typeproject) ? ['id' => (int) $project  -> typeproject   ->   id, 'name'  => e($project->typeproject->name)] : null,

        ];

        $permissions_array['available_actions'] = [
            'update' => Gate::allows('update', Project::class),
            'delete' => Gate::allows('delete', Project::class),
            'view'   => Gate::allows('view',Project::class)
        ];

        $array += $permissions_array;

        return $array;
    }

    public function transformAssetsDatatable($project) {
        return (new DatatablesTransformer)->transformDatatables($project);
    }



}
