<?php
namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\Models\License;
use App\Models\Project;
use Gate;
use Illuminate\Database\Eloquent\Collection;

class LicensesTransformer
{

    public function transformLicenses (Collection $licenses, $total)
    {
        $array = array();
        foreach ($licenses as $license) {
            $array[] = self::transformLicense($license);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformLicense (License $license)
    {
        $array = [
            'id'             => (int) $license->id,
            'name'           => e($license->name),
            'company'        => ($license->company)      ? ['id' => (int)  $license->company     ->id,'name'=> e($license->company      ->  name)] : null,
            'supplier'       => ($license->supplier)     ? ['id' => (int)  $license->supplier    ->id,'name'=> e($license->supplier     ->  name)] : null,
            'project'        => ($license->project)      ? ['id' => (int)  $license->project     ->id,'name'=> e($license->project      ->  name)] : null,
            'manufacturer'   => ($license->manufacturer) ? ['id' => (int)  $license->manufacturer->id,'name'=> e($license->manufacturer ->  name)] : null,
            'depreciation'   => ($license->depreciation) ? ['id' => (int)  $license->depreciation->id,'name'=> e($license->depreciation ->  name)] : null,
            'category'       => ($license->category)     ? ['id' => (int)  $license->category    ->id,'name'=> e($license->category     ->  name)] : null,
            'product_key'    => (Gate::allows('viewKeys', License::class)) ? e($license->serial) : '------------',
            'order_number'   => e($license->order_number),
            'purchase_order' => e($license->purchase_order),
            'purchase_date'      => Helper::getFormattedDateObject($license->purchase_date, 'date'),
            'termination_date'   => Helper::getFormattedDateObject($license->termination_date, 'date'),
            'activation_date'    => Helper::getFormattedDateObject($license->activation_date, 'date'),

            'depreciation'       => ($license->depreciation) ? ['id' => (int) $license->depreciation->id,'name'=> e($license->depreciation->name)] : null,
            'purchase_cost'      =>  Helper::formatCurrencyOutput($license->purchase_cost),
            'notes'              => e($license->notes),
            'expiration_date'    => Helper::getFormattedDateObject($license->expiration_date, 'date'),
            'seats'              => (int) $license->seats,
            'free_seats_count'   => (int) $license->free_seats_count,
            'license_name'       =>  e($license->license_name),
            'license_email'      => e($license->license_email),
            'reassignable'       => ($license->reassignable == 1) ? true : false,
            'user_can_checkout'  => (bool) ($license->free_seats_count > 0),
            'maintained' => ($license->maintained == 1) ? true : false,
            'created_at' => Helper::getFormattedDateObject($license->created_at, 'datetime'),
            'updated_at' => Helper::getFormattedDateObject($license->updated_at, 'datetime'),
        ];

        $permissions_array['available_actions'] = [
            'checkout' => Gate::allows('checkout', License::class),
            'checkin' => Gate::allows('checkin', License::class),
            'clone' => Gate::allows('create', License::class),
            'update' => Gate::allows('update', License::class),
            'delete' => Gate::allows('delete', License::class),
            'view' => Gate::allows('view', License::class),

        ];

        $array += $permissions_array;

        return $array;
    }

    public function transformAssetsDatatable($licenses) {
        return (new DatatablesTransformer)->transformDatatables($licenses);
    }



}
