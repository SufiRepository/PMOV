<?php
namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\Models\PaymentTask;
use App\Models\Project;
use App\Models\User;
use Gate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class PaymentTasksTransformer
{

    public function transformPaymentTasks (Collection $paymenttasks, $total)
    {
        $array = array();
        foreach ($paymenttasks as $paymenttask) {
            $array[] = self::transformPaymentTask($paymenttask);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformPaymentTask (PaymentTask $paymenttask)
    {
        $array = [
            'id'   => (int)$paymenttask->id,
            'name' => e($paymenttask->name),
            'details' => e($paymenttask->details),

            'file_path'     => e($paymenttask->file_path),


        ];

        $permissions_array['available_actions'] = [
            
            'update' => Gate::allows('update', PaymentTask::class) ,
            'delete' => Gate::allows('delete', PaymentTask::class),
        ];

        $array += $permissions_array;

        return $array;
    }


}
