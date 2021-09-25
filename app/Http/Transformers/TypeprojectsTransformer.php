<?php
namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\Models\Typeproject;
use Gate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class TypeprojectsTransformer
{

    public function transformTypeprojects (Collection $typeprojects, $total)
    {
        $array = array();
        foreach ($typeprojects as $typeproject) {
            $array[] = self::transformTypeproject($typeproject);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformTypeproject (Typeproject $typeproject = null)
    {
        if ($typeproject) {

            $array = [
                'id' => (int) $typeproject->id,
                'name' => e($typeproject->name),
                'image' =>   ($typeproject->image) ? Storage::disk('public')->url('typeprojects/'.e($typeproject->image)) : null,
                'created_at' => Helper::getFormattedDateObject($typeproject->created_at, 'datetime'),
                'updated_at' => Helper::getFormattedDateObject($typeproject->updated_at, 'datetime'),
                'company'       => e($typeproject->company)     ? ['id' => (int) $typeproject  -> company       ->   id, 'name'  => e($typeproject->company->name)] : null,


            ];

            $permissions_array['available_actions'] = [
                'update' => Gate::allows('update', Typeproject::class),
                'delete' => (Gate::allows('delete', Typeproject::class) && ($typeproject->assets_count == 0) && ($typeproject->licenses_count == 0)  && ($typeproject->accessories_count == 0)),
            ];

            $array += $permissions_array;

            return $array;
        }


    }



}
