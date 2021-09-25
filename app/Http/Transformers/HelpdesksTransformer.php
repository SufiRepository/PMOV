<?php
namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\Models\Helpdesk;
use Gate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class HelpdesksTransformer
{

    public function transformHelpdesks (Collection $helpdesks)
    {
        $array = array();
        foreach ($helpdesks as $helpdesk) {
            $array[] = self::transformHelpdesk($helpdesk);
        }
        return (new DatatablesTransformer)->transformDatatables($array);
    }

    public function transformHelpdesk (Helpdesk $helpdesk = null)
    {
        if ($helpdesk) {

            $array = [
                'id' => (int) $helpdesk->id,
                'name' => e($helpdesk->name),
                'client_name' => e($helpdesk->client_name),
                'client_phone' => e($helpdesk->client_phone),
                'client_email' => e($helpdesk->client_email),
                'client_address' => e($helpdesk->client_address),
                'priority' => e($helpdesk->priority),
                'status' => e($helpdesk->status),
                'due_date' => e($helpdesk->due_date),
                'description' => e($helpdesk->description),

                'engineer' => e($helpdesk->engineer),
                'solution' => e($helpdesk->solution),
                'solution_status' => e($helpdesk->solution_status),
                'responded_date' => e($helpdesk->responded_date),

                'user'       => e($helpdesk->user)    ? ['id' => (int) $helpdesk  -> user  -> id, 'name'  => e($helpdesk->user->getFullNameAttribute())] : null,
                'location' => ($helpdesk->location) ? ['id' => $helpdesk->location->id,'name'=> e($helpdesk->location->name)] : null,
                'company' => ($helpdesk->company) ? ['id' => $helpdesk->company->id,'name'=> e($helpdesk->company->name)] : null,
                'created_at' => Helper::getFormattedDateObject($helpdesk->created_at, 'datetime'),
                'updated_at' => Helper::getFormattedDateObject($helpdesk->updated_at, 'datetime'),
                // 'deleted_at' => Helper::getFormattedDateObject($helpdesk->deleted_at, 'datetime'),
            ];

            $permissions_array['available_actions'] = [
                'update' => (($helpdesk->deleted_at=='') && (Gate::allows('update', Helpdesk::class))),
                'restore' => (($helpdesk->deleted_at!='') && (Gate::allows('create', Helpdesk::class))),
                // 'delete' => $helpdesk->isDeletable(),
            ];

            $array += $permissions_array;

            return $array;
        }


    }



}
