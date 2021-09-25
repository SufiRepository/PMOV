<?php
namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\Models\Contractor;
use Gate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class ContractorsTransformer
{

    public function transformContractors (Collection $contractor, $total)
    {
        $array = array();
        foreach ($contractor as $contractor) {
            $array[] = self::transformContractor($contractor);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformContractor (Contractor $contractor = null)
    {
        if ($contractor) {

            $array = [
                'id'        => (int) $contractor->id,
                'name'      => e($contractor->name),
                'image'     =>   ($contractor->image) ? Storage::disk('public')->url('contractors/'.e($contractor->image)) : null,
                'url'       => e($contractor->url),
                'address'   => e($contractor->address),
                'address2'  => e($contractor->address2),
                'city'      => e($contractor->city),
                'state'     => e($contractor->state),
                'country'   => e($contractor->country),
                'zip'       => e($contractor->zip),
                'fax'       => e($contractor->fax),
                'phone'     => e($contractor->phone),
                'email'     => e($contractor->email),
                'contact'   => e($contractor->contact),
                'assets_count'      => (int) $contractor->assets_count,
                'accessories_count' => (int) $contractor->accessories_count,
                'licenses_count'    => (int) $contractor->licenses_count,

                'project'    => e($contractor->project)  ? ['id' => (int) $contractor  -> project    ->   id, 'name'  => e($contractor->project->name)] : null,

                'notes'             => ($contractor->notes) ? e($contractor->notes) : null,
                'created_at' => Helper::getFormattedDateObject($contractor->created_at, 'datetime'),
                'updated_at' => Helper::getFormattedDateObject($contractor->updated_at, 'datetime'),

            ];

            $permissions_array['available_actions'] = [
                'update' => Gate::allows('update', Contractor::class),
                'delete' => (Gate::allows('delete', Contractor::class) && ($contractor->assets_count == 0) && ($contractor->licenses_count == 0)  && ($contractor->accessories_count == 0)),
            ];

            $array += $permissions_array;

            return $array;
        }


    }



}
