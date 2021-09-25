<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Transformers\SelectlistTransformer;
use App\Http\Transformers\ClientsTransformer;
use App\Models\Client;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', Client::class);
        $allowed_columns = [
            'id',
            'name',
            'department',
            'address',
            'phone',
            'contact',
            'fax',
            'email',
            'image',
            // 'assets_count',
            // 'licenses_count',
            // 'accessories_count',
            'url'];
        
        $clients = Client::select(
                array(
                    'id',
                    'name',
                    'department',
                    'address',
                    'address2',
                    'city',
                    'state',
                    'country',
                    'fax', 
                    'phone',
                    'email',
                    'contact',
                    'created_at',
                    'updated_at',
                    'deleted_at',
                    'image',
                    'notes')
                );
            //     ->withCount('assets as assets_count')
            // ->withCount('licenses as licenses_count')
            // ->withCount('accessories as accessories_count');

            $clients = Company::scopeCompanyables($clients);

        if ($request->filled('search')) {
            $clients = $clients->TextSearch($request->input('search'));
        }

        // Set the offset to the API call's offset, unless the offset is higher than the actual count of items in which
        // case we override with the actual count, so we should return 0 items.
        $offset = (($clients) && ($request->get('offset') > $clients->count())) ? $clients->count() : $request->get('offset', 0);

        // Check to make sure the limit is not higher than the max allowed
        ((config('app.max_results') >= $request->input('limit')) && ($request->filled('limit'))) ? $limit = $request->input('limit') : $limit = config('app.max_results');

        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';
        $clients->orderBy($sort, $order);

        $total = $clients->count();
        $clients = $clients->skip($offset)->take($limit)->get();
        return (new ClientsTransformer)->transformClients($clients, $total);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Client::class);
        $client = new Client;
        $client->fill($request->all());

        if ($client->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $client, trans('admin/clients/message.create.success')));
        }
        return response()->json(Helper::formatStandardApiResponse('error', null, $client->getErrors()));

    }

    /**
     * Display the specified resource.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', Client::class);
        $client = Client::findOrFail($id);
        return (new ClientsTransformer)->transformClient($client);
    }


    /**
     * Update the specified resource in storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('update', Client::class);
        $client = Client::findOrFail($id);
        $client->fill($request->all());

        if ($client->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $client, trans('admin/clients/message.update.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $client->getErrors()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete', Client::class);
        $client = Client::with('asset_maintenances', 'assets', 'licenses')->withCount('asset_maintenances as asset_maintenances_count','assets as assets_count', 'licenses as licenses_count')->findOrFail($id);
        $this->authorize('delete', $client);


        if ($client->assets_count > 0) {
            return response()->json(Helper::formatStandardApiResponse('error', null,  trans('admin/clients/message.delete.assoc_assets', ['asset_count' => (int) $client->assets_count])));
        }

        if ($client->asset_maintenances_count > 0) {
            return response()->json(Helper::formatStandardApiResponse('error', null,  trans('admin/clients/message.delete.assoc_maintenances', ['asset_maintenances_count' => $client->asset_maintenances_count])));
        }

        if ($client->licenses_count > 0) {
            return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/clients/message.delete.assoc_licenses', ['licenses_count' => (int) $client->licenses_count])));
        }

        $client->delete();
        return response()->json(Helper::formatStandardApiResponse('success', null,  trans('admin/clients/message.delete.success')));

    }

    /**
     * Gets a paginated collection for the select2 menus
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0.16]
     * @see \App\Http\Transformers\SelectlistTransformer
     *
     */
    public function selectlist(Request $request)
    {

        $clients = Client::select([
            'id',
            'name',
            'image',
        ]);

        if ($request->filled('search')) {
            $clients = $clients->where('clients.name', 'LIKE', '%'.$request->get('search').'%');
        }

        $clients = $clients->orderBy('name', 'ASC')->paginate(50);

        // Loop through and set some custom properties for the transformer to use.
        // This lets us have more flexibility in special cases like assets, where
        // they may not have a ->name value but we want to display something anyway
        foreach ($clients as $client) {
            $client->use_text = $client->name;
            $client->use_image = ($client->image) ? Storage::disk('public')->url('clients/'.$client->image, $client->image) : null;
        }

        return (new SelectlistTransformer)->transformSelectlist($clients);

    }

}
