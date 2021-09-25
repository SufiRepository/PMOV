<?php
namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\Models\Team;
use App\Models\Project;
use App\Models\User;
use Gate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class TeamsTransformer
{

    public function transformTeams (Collection $teams, $total)
    {
        $array = array();
        foreach ($teams as $team) {
            $array[] = self::transformTeam($team);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformTeam (Team $team)
    {
        $array = [
            'id'   => (int)$team->id,
            'name' => e($team->name),
            'details' => e($team->details),
            'user'          => e($team->user)        ? ['id' => (int) $team  -> user          ->   id, 'name'  => e($team->user->getFullNameAttribute())] : null,
            'role'        => e($team->role)      ? ['id' => (int) $team  -> role        ->   id, 'name'  => e($team->role->name)] : null,
            'project'        => e($team->project)      ? ['id' => (int) $team  -> project        ->   id, 'name'  => e($team->project->name)] : null,
            'created_at' => Helper::getFormattedDateObject($team->created_at, 'datetime'),
            'updated_at' => Helper::getFormattedDateObject($team->updated_at, 'datetime'),

        ];

        $permissions_array['available_actions'] = [
            
            // 'update' => Gate::allows('update', Team::class) ,
            'delete' => Gate::allows('delete', Team::class),
        ];

        $array += $permissions_array;

        return $array;
    }


}
