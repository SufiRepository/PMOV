<?php
namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\Models\Accessory;
use App\Models\Project;
use App\Models\Contractor;
use App\Models\User;
use App\Models\Company;
use App\Models\Assignwork;

use Gate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class AssignworksTransformer
{

    public function transformAssignworks (Collection $assignwork, $total)
    {
        $array = array();
        foreach ($assignwork as $assignwork) {
            $array[] = self::transformAssignwork($assignwork);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformAssignwork (Assignwork $assignwork)
    {
        $array = [
            'id'   => $assignwork->id,
            'company'        => ($assignwork->company)        ? ['id' => $assignwork->company->id,'name'=> e($assignwork->company->name)] : null,
            'project'        => ($assignwork->project)        ? ['id' => $assignwork->project->id,'name'=> e($assignwork->project->name)] : null,
            'contractor'     => ($assignwork->contractor)     ? ['id' => $assignwork->contractor->id,'name'=> e($assignwork->contractor->name)] : null,
            'user'           => ($assignwork->user)           ? ['id' => $assignwork->user->id,'name'=> e($assignwork->user->name)] : null,
            'date_submit'    => Helper::getFormattedDateObject($assignwork->date_submit, 'date'),
            'details'        => e($assignwork->details),
            'project_value'  => e($assignwork->project_value),

            


            'created_at' => Helper::getFormattedDateObject($assignwork->created_at, 'datetime'),
            'updated_at' => Helper::getFormattedDateObject($assignwork->updated_at, 'datetime'),

        ];

        $permissions_array['available_actions'] = [

            'update' => Gate::allows('update', Assignwork::class) ,
            'delete' => Gate::allows('delete', Assignwork::class),
        ];
    
        $array += $permissions_array;

        return $array;
    }


    
    



}
