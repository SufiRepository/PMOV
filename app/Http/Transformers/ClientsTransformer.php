<?php
namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\Models\Client;
use Gate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class ClientsTransformer
{

    public function transformClients (Collection $client, $total)
    {
        $array = array();
        foreach ($client as $client) {
            $array[] = self::transformClient($client);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformClient (Client $client = null)
    {
        if ($client) {

            $array = [
                'id'             => (int) $client->id,
                'name'          => e($client->name),
                'department'  => e($client->department),
                'image'     => ($client->image) ? Storage::disk('public')->url('clients/'.e($client->image)) : null,
                'url'       => e($client->url),
                'address'   => e($client->address),
                'address2'  => e($client->address2),
                'city'      => e($client->city),
                'state'     => e($client->state),
                'country'   => e($client->country),
                'zip'       => e($client->zip),
                'fax'       => e($client->fax),
                'phone'     => e($client->phone),
                'email'     => e($client->email),
                'contact'   => e($client->contact),
                'assets_count'      => (int) $client->assets_count,
                'accessories_count' => (int) $client->accessories_count,
                'licenses_count'    => (int) $client->licenses_count,
                'notes'             => ($client->notes) ? e($client->notes) : null,
                'created_at' => Helper::getFormattedDateObject($client->created_at, 'datetime'),
                'updated_at' => Helper::getFormattedDateObject($client->updated_at, 'datetime'),

            ];

            $permissions_array['available_actions'] = [
                'update' => Gate::allows('update', Client::class),
                'delete' => (Gate::allows('delete', Client::class) && ($client->assets_count == 0) && ($client->licenses_count == 0)  && ($client->accessories_count == 0)),
            ];

            $array += $permissions_array;

            return $array;
        }


    }



}
