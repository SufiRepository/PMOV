<?php
namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\Models\ImplementationPlan;
use Gate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class ImplementationPlansTransformer
{

    public function transformImplementationPlans (Collection $implementationplans, $total)
    {
        $array = array();
        foreach ($implementationplans as $implementationplan) {
            $array[] = self::transformImplementationPlan($implementationplan);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformImplementationPlan (ImplementationPlan $implementationplan)
    {
        $array = [
            'id'            => (int) $implementationplan->id,
            'name'          => e($implementationplan->name),
            'details'       => e($implementationplan->details),  
          
            // 'status_label'      => ($implementationplan->implementationstatus) ? ['id' => (int) $implementationplan  -> implementationstatus ->   id, 'name'=> e($implementationplan->implementationstatus->name), 'status_type'=> e($implementationplan->implementationstatus->getStatuslabelType()),'status_meta' => e($implementationplan->present()->statusMeta),] : null,
            'contractor'        => e($implementationplan->contractor)          ? ['id' => (int) $implementationplan  -> contractor           ->   id, 'name'  => e($implementationplan->contractor->name)] : null,
            'supplier'            => e($implementationplan->supplier)              ? ['id' => (int) $implementationplan  -> supplier               ->   id, 'name'  => e($implementationplan->supplier->name)] : null,
            'status'            => e($implementationplan->statustask)              ? ['id' => (int) $implementationplan  -> statustask               ->   id, 'name'  => e($implementationplan->statustask->name)] : null,


            'contract_start_date'    => Helper::getFormattedDateObject($implementationplan->contract_start_date, 'date'),  
            'contract_end_date'      => Helper::getFormattedDateObject($implementationplan->contract_end_date, 'date'),
            'actual_start_date'      => Helper::getFormattedDateObject($implementationplan->actual_start_date, 'date'),  
            'actual_end_date'        => Helper::getFormattedDateObject($implementationplan->actual_end_date, 'date'),
            'actual_duration'        => e($implementationplan->actual_duration),
            'contract_duration'      => e($implementationplan->contract_duration),

            'created_at'    => Helper::getFormattedDateObject($implementationplan->created_at, 'datetime'),
            'updated_at'    => Helper::getFormattedDateObject($implementationplan->updated_at, 'datetime'),
        ];

        $permissions_array['available_actions'] = [
            
            'update' => Gate::allows('update', ImplementationPlan::class),
            'delete' => Gate::allows('delete', ImplementationPlan::class),
        ];
        $array += $permissions_array;
        return $array;
    }


}
