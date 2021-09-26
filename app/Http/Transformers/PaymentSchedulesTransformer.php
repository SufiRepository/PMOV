<?php
namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\Models\PaymentSchedule;
use App\Models\Project;
use App\Models\User;
use Gate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class PaymentSchedulesTransformer
{

    public function transformPaymentSchedules (Collection $paymentschedules, $total)
    {
        $array = array();
        foreach ($paymentschedules as $paymentschedule) {
            $array[] = self::transformPaymentSchedule($paymentschedule);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformPaymentSchedule (PaymentSchedule $paymentschedule)
    {
        $array = [
            'id'   => (int)$paymentschedule->id,
            'name' => e($paymentschedule->task_name),
            'description' => e($paymentschedule->description),
            'paymentdate' => e($paymentschedule->costing),
            'details' => e($paymentschedule->details),
            'paymentdate'          => Helper::getFormattedDateObject($paymentschedule->paymentdate, 'datetime'),

            'contractor'  => e($paymentschedule->contractor)          ? ['id' => (int) $paymentschedule  -> contractor           ->   id, 'name'  => e($paymentschedule->contractor->name)] : null,
            'supplier'    => e($paymentschedule->supplier)            ? ['id' => (int) $paymentschedule  -> supplier             ->   id, 'name'  => e($paymentschedule->supplier->name)] : null,


        ];

        $permissions_array['available_actions'] = [
            
            'update' => Gate::allows('update', PaymentSchedule::class) ,
            'delete' => Gate::allows('delete', PaymentSchedule::class),
        ];

        $array += $permissions_array;

        return $array;
    }


}
