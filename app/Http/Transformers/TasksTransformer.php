<?php
namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\Models\Task;
use Gate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class TasksTransformer
{

    public function transformTasks (Collection $tasks, $total)
    {
        $array = array();
        foreach ($tasks as $task) {
            $array[] = self::transformTask($task);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformTask (Task $task)
    {
        $array = [
            'id'            => (int) $task->id,
            'name'          => e($task->name),
            'details'       => e($task->details),  
            'contract_duration' => e($task->contract_duration) ,
            'actual_duration'   => e($task->actual_duration) ,
            'amount_task'         => Helper::formatCurrencyOutput($task->amount_task),
            'type'       => e($task->billingOrpayment),  
            'typetask'       => e($task->milestone),  
            'priority'      =>e($task->priority),
            'numsubtask'    =>e($task->subtasks),
            'statustask'  => e($task->statustask_id),  


            // 'manager'   => e($task->manager_id) ,
            // 'teammember'   => e($task->team_member) ,


        
            'status_label' => ($task->taskstatus) ? ['id' => (int) $task->taskstatus->id, 'name'=> e($task->taskstatus->name), 'status_type'=> e($task->taskstatus->getStatuslabelType()),'status_meta' => e($task->present()->statusMeta),] : null,

            // 'statustask'  => e($task->statustask)  ? ['id' => (int) $task  -> statustask -> id, 'name'  => e($task->statustask->name)] : null,

            'contractor'  => e($task->contractor)  ? ['id' => (int) $task  -> contractor -> id, 'name'  => e($task->contractor->name)] : null,

            'supplier'  => e($task->supplier)  ? ['id' => (int) $task  -> supplier -> id, 'name'  => e($task->supplier->name)] : null,

            // 'manager'          => e($task->team)    ? ['id' => (int) $task  -> team  -> id, 'name'  => e($task->team->user_id)] : null,
        
            // 'teammember'       => e($task->user)    ? ['id' => (int) $task  -> user  -> id, 'name'  => e($task->user->getFullNameAttribute())] : null,


            'user'       => e($task->user)    ? ['id' => (int) $task  -> user  -> id, 'name'  => e($task->user->getFullNameAttribute())] : null,

            'paymenttask'  => e($task->paymenttask)  ? ['id' => (int) $task  -> paymenttask -> id, 'name'  => e($task->payment)] : null,

            'contract_start_date'          => Helper::getFormattedDateObject($task->contract_start_date, 'date'),
            'contract_end_date'            => Helper::getFormattedDateObject($task->contract_end_date, 'date'),
            'actual_start_date'            => Helper::getFormattedDateObject($task->actual_start_date, 'date'),
            'actual_end_date'              => Helper::getFormattedDateObject($task->actual_end_date, 'date'),          

            'created_at'                   => Helper::getFormattedDateObject($task->created_at, 'datetime'),
            'updated_at'                   => Helper::getFormattedDateObject($task->updated_at, 'datetime'),
        ];

        $permissions_array['available_actions'] = [
            
            'update' => Gate::allows('update', Task::class),
            'delete' => Gate::allows('delete', Task::class),
            'clone' => Gate::allows('clone', Task::class),

        ];
        $array += $permissions_array;
        return $array;
    }


}
