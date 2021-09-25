<?php
namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\Models\BillQuantity;
use Gate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class BillQuantitiesTransformer
{

    public function transformBillQuantities (Collection $billquantity, $total)
    {
        $array = array();
        foreach ($billquantity as $billquantity) {
            $array[] = self::transformBillQuantity($billquantity);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformBillQuantity (BillQuantity $billquantity = null)
    {
        if ($billquantity) {

            $array = [
                'id'             => (int) $billquantity->id,

                'name'           => e($billquantity->name),
                'serial'         => e($billquantity->serial),
                'modelNo'         => e($billquantity->modelNo),
                'type'           => e($billquantity->type),
                'option'           => e($billquantity->option),
                'remark'           => e($billquantity->reamrk),


                'sale_value'     => e($billquantity->sale_value),
                'buy_value'      => e($billquantity->buy_value),
                'net_profit'     => e($billquantity->net_profit),

                'notes'             => ($billquantity->notes) ? e($billquantity->notes) : null,
                'image'          => ($billquantity->image) ? Storage::disk('public')->url('billquantities/'.e($billquantity->image)) : null,
                
                'created_at' => Helper::getFormattedDateObject($billquantity->created_at, 'datetime'),
                'updated_at' => Helper::getFormattedDateObject($billquantity->updated_at, 'datetime'),

            ];

            $permissions_array['available_actions'] = [
                'update' => Gate::allows('update', BillQuantity::class),
                'delete' => (Gate::allows('delete', BillQuantity::class)),
            ];

            $array += $permissions_array;

            return $array;
        }


    }



}
