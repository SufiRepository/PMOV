<?php
namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\Models\PaymentSubtask;
use App\Models\Project;
use App\Models\User;
use Gate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class PaymentSubtasksTransformer
{

    public function transformPaymentSubtasks (Collection $payementsubtasks, $total)
    {
        $array = array();
        foreach ($payementsubtasks as $paymentsubtask) {
            $array[] = self::transformPaymentSubtask($paymentsubtask);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformPaymentSubtask (PaymentSubtask $paymentsubtask)
    {
        $array = [
            'id'   => (int)$paymentsubtask->id,
            'name' => e($paymentsubtask->name),
            'details' => e($paymentsubtask->details),

        ];

        $permissions_array['available_actions'] = [
            
            'update' => Gate::allows('update', PaymentSubtask::class) ,
            'delete' => Gate::allows('delete', PaymentSubtask::class),
        ];

        $array += $permissions_array;

        return $array;
    }


}
