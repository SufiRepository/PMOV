<?php
namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\Models\Billing;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Gate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class BillingsTransformer
{

    public function transformBillings (Collection $billings, $total)
    {
        $array = array();
        foreach ($billings as $billing) {
            $array[] = self::transformBilling($billing);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformBilling (Billing $billing)
    {
        $array = [
            'id'   => (int)$billing->id,
            'task_name' => e($billing->task_name),
            'amount' => e($billing->amount),
            'billingdate' => e($billing->billingdate),

            // 'billingdate'          => Helper::getFormattedDateObject($billing->billingdate, 'datetime'),
            'description' => e($billing->description),

        ];

        $permissions_array['available_actions'] = [
            
            // 'update' => Gate::allows('update', Billing::class) ,
            // 'delete' => Gate::allows('delete', Billing::class),
        ];

        $array += $permissions_array;

        return $array;
    }
}
