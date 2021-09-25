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
            'name' => e($billing->name),
            'details' => e($billing->details),
            'costing' => e($billing->costing),


            'project'        => ($billing->project)        ? ['id' => $billing->project->id,'name'=> e($billing->project->name)] : null,
            'task'        => ($billing->task)        ? ['id' => $billing->task->id,'name'=> e($billing->task->name)] : null,

            'invoice_no' => e($billing->invoice_no),
            'deliveryorder_no' => e($billing->deliveryorder_no),
            'supportingdocument' => e($billing->supportingdocument),
            
        ];

        $permissions_array['available_actions'] = [
            
            // 'update' => Gate::allows('update', Billing::class) ,
            // 'delete' => Gate::allows('delete', Billing::class),
        ];

        $array += $permissions_array;

        return $array;
    }
}
