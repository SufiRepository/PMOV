<?php
namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\Models\Work;
use Gate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class WorksTransformer
{

    public function transformWorks (Collection $work, $total)
    {
        $array = array();
        foreach ($work as $work) {
            $array[] = self::transformWork($work);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformWork (Work $work = null)
    {
        if ($work) {

            $array = [
                'id'            => (int) $work->id,
                'name'          => e($work->name),
                'due_date'      => Helper::getFormattedDateObject($work->due_date, 'date'),
                'start_date'    => Helper::getFormattedDateObject($work->start_date, 'date'),
                'details'       => e($work->details),
                'costing'       => e($work->costing),
                'location'      => e($work->location)    ? ['id' => (int) $work  -> location      ->   id, 'name'  => e($work->location->name)] : null,
                'user'          => e($work->user)        ? ['id' => (int) $work  -> user          ->   id, 'name'  => e($work->user->getFullNameAttribute())] : null,
                'company'       => e($work->company)     ? ['id' => (int) $work  -> company       ->   id, 'name'  => e($work->company->name)] : null,
                'client'        => e($work->client)      ? ['id' => (int) $work  -> client        ->   id, 'name'  => e($work->client->name)] : null,
                'contractor'    => e($work->contractor)  ? ['id' => (int) $work  -> contractor    ->   id, 'name'  => e($work->contractor->name)] : null,
    
            ];

            $permissions_array['available_actions'] = [
                'update' => Gate::allows('update', Work::class),
                'delete' => (Gate::allows('delete', Work::class) && ($work->assets_count == 0) && ($work->licenses_count == 0)  && ($work->accessories_count == 0)),
            ];

            $array += $permissions_array;

            return $array;
        }


    }



}
