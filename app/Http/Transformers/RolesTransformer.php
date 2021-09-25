<?php
namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\Models\Role;
use Gate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class RolesTransformer
{

    public function transformRoles (Collection $role, $total)
    {
        $array = array();
        foreach ($role as $role) {
            $array[] = self::transformRole($role);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformRole (Role $role = null)
    {
        if ($role) {

            $array = [
                'id'        => (int) $role->id,
                'name'      => e($role->name),
                'access_level' => e($role->access_level),

                'company'    => e($role->company)  ? ['id' => (int) $role  -> company    ->   id, 'name'  => e($role->company->name)] : null,

                'created_at' => Helper::getFormattedDateObject($role->created_at, 'datetime'),
                'updated_at' => Helper::getFormattedDateObject($role->updated_at, 'datetime'),

            ];

            $permissions_array['available_actions'] = [
                'update' => Gate::allows('update', Role::class),
                'delete' => (Gate::allows('delete', Role::class) ),
             ];

            $array += $permissions_array;

            return $array;
        }


    }



}
