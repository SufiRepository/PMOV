<?php
namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\Models\Subtask;
use Gate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class SubtasksTransformer
{

    public function transformSubtasks (Collection $subtasks, $total)
    {
        $array = array();
        foreach ($subtasks as $subtask) {
            $array[] = self::transformSubtask($subtask);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformSubtask (Subtask $subtask)
    {
        $array = [
            'id'            => (int) $subtask->id,
            'name'          => e($subtask->name),
            'details'       => e($subtask->details),  
            'contract_duration' => e($subtask->contract_duration) ,
            'actual_duration'   => e($subtask->actual_duration) ,
            'amount_task'       => e($subtask->amount_task),
            'type'              => e($subtask->billingOrpayment),  
            'priority'          => e($subtask->priority),

            'task'        => e($subtask->task)  ? ['id' => (int) $subtask  -> task -> id, 'name'  => e($subtask->task->name)] : null,

            // 'status_label' => ($subtask->subtaskstatus) ? ['id' => (int) $subtask->subtaskstatus->id, 'name'=> e($subtask->subtaskstatus->name), 'status_type'=> e($subtask->subtaskstatus->getStatuslabelType()),'status_meta' => e($subtask->present()->statusMeta),] : null,
           
            'status'  => e($subtask->statustask)  ? ['id' => (int) $subtask  -> statustask -> id, 'name'  => e($subtask->statustask->name)] : null,

            'contractor'  => e($subtask->contractor)  ? ['id' => (int) $subtask  -> contractor -> id, 'name'  => e($subtask->contractor->name)] : null,
            'supplier'  => e($subtask->supplier)  ? ['id' => (int) $subtask  -> supplier -> id, 'name'  => e($subtask->supplier->name)] : null,
            'paymentsubtask'  => e($subtask->paymentsubtask)  ? ['id' => (int) $subtask  -> paymentsubtask -> id, 'name'  => e($subtask->paymentsubtask_id)] : null,

            'contract_start_date'          => Helper::getFormattedDateObject($subtask->contract_start_date, 'date'),
            'contract_end_date'            => Helper::getFormattedDateObject($subtask->contract_end_date, 'date'),
            'actual_start_date'            => Helper::getFormattedDateObject($subtask->actual_start_date, 'date'),
            'actual_end_date'              => Helper::getFormattedDateObject($subtask->actual_end_date, 'date'),          

            'created_at'    => Helper::getFormattedDateObject($subtask->created_at, 'datetime'),
            'updated_at'    => Helper::getFormattedDateObject($subtask->updated_at, 'datetime'),
        ];

        $permissions_array['available_actions'] = [
            
            // 'update' => Gate::allows('update', Subtask::class),
            'delete' => Gate::allows('delete', Subtask::class),
            'view'   => Gate::allows('view',   Subtask::class),

        ];
        $array += $permissions_array;
        return $array;
    }


}
