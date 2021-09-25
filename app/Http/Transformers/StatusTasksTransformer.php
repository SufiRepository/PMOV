<?php
namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\Models\StatusTask;
use Gate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class StatusTasksTransformer
{

    public function transformStatusTasks (Collection $statustasks, $total)
    {
        $array = array();
        foreach ($statustasks as $statustask) {
            $array[] = self::transformStatusTask($statustask);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformStatusTask (StatusTask $statustask = null)
    {
        if ($statustask) {

            $array = [
                'id' => (int) $statustask->id,
                'name' => e($statustask->name),
               

            ];

            $permissions_array['available_actions'] = [
                'update' => Gate::allows('update', StatusTask::class),
                'delete' => (Gate::allows('delete', StatusTask::class) && ($statustask->assets_count == 0) && ($statustask->licenses_count == 0)  && ($statustask->accessories_count == 0)),
            ];

            $array += $permissions_array;

            return $array;
        }


    }



}
