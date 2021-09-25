<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Transformers\SelectlistTransformer;
use App\Http\Transformers\WorksTransformer;
use App\Models\Client;
use App\Models\Company;
use App\Models\Contractor;
use App\Models\User;
use App\Models\Work;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WorksController extends Controller
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
        $this->authorize('view', Work::class);
        $allowed_columns = [
            'id',
            'name',
            'company_id',
            'user_id',
            'due_date',
            'created_at',
            'deleted_at',
            'start_date', 
            'costing', 
            'details',
            'location_id',
            'client_id',
            'contractor_id',
        
        ];
        
        $work = Work::select(
                array(
                    'id',
                    'name',
                    'company_id',
                    'user_id',
                    'due_date',
                    'created_at',
                    'deleted_at',
                    'start_date', 
                    'costing', 
                    'details',
                    'location_id',
                    'client_id',
                    'contractor_id',
        
                    
                    )
                );
            //     ->withCount('assets as assets_count')
            // ->withCount('licenses as licenses_count')
            // ->withCount('accessories as accessories_count');

            $works = Company::scopeCompanyables($works);

        if ($request->filled('search')) {
            $works = $works->TextSearch($request->input('search'));
        }

        // Set the offset to the API call's offset, unless the offset is higher than the actual count of items in which
        // case we override with the actual count, so we should return 0 items.
        $offset = (($works) && ($request->get('offset') > $works->count())) ? $works->count() : $request->get('offset', 0);

        // Check to make sure the limit is not higher than the max allowed
        ((config('app.max_results') >= $request->input('limit')) && ($request->filled('limit'))) ? $limit = $request->input('limit') : $limit = config('app.max_results');

        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';
        $works->orderBy($sort, $order);

        $total = $works->count();
        $works = $works->skip($offset)->take($limit)->get();
        return (new WorksTransformer)->transformWorks($works, $total);
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
        $this->authorize('create', Work::class);
        $work = new Work;
        $work->fill($request->all());

        if ($work->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $work, trans('admin/works/message.create.success')));
        }
        return response()->json(Helper::formatStandardApiResponse('error', null, $work->getErrors()));

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
        $this->authorize('view', Work::class);
        $work = Work::findOrFail($id);
        return (new WorksTransformer)->transformWork($work);
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
        $this->authorize('update', Work::class);
        $work = Work::findOrFail($id);
        $work->fill($request->all());

        if ($work->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $work, trans('admin/works/message.update.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $work->getErrors()));
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
        $this->authorize('delete', Work::class);
        $work = Work::with('asset_maintenances', 'assets', 'licenses')->withCount('asset_maintenances as asset_maintenances_count','assets as assets_count', 'licenses as licenses_count')->findOrFail($id);
        $this->authorize('delete', $work);


        if ($work->assets_count > 0) {
            return response()->json(Helper::formatStandardApiResponse('error', null,  trans('admin/works/message.delete.assoc_assets', ['asset_count' => (int) $client->assets_count])));
        }

        if ($work->asset_maintenances_count > 0) {
            return response()->json(Helper::formatStandardApiResponse('error', null,  trans('admin/works/message.delete.assoc_maintenances', ['asset_maintenances_count' => $client->asset_maintenances_count])));
        }

        if ($work->licenses_count > 0) {
            return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/works/message.delete.assoc_licenses', ['licenses_count' => (int) $client->licenses_count])));
        }

        $work->delete();
        return response()->json(Helper::formatStandardApiResponse('success', null,  trans('admin/works/message.delete.success')));

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

        $works = Work::select([
            'id',
            'name',
            'image',
        ]);

        if ($request->filled('search')) {
            $works = $works->where('works.name', 'LIKE', '%'.$request->get('search').'%');
        }

        $works = $works->orderBy('name', 'ASC')->paginate(50);

        // Loop through and set some custom properties for the transformer to use.
        // This lets us have more flexibility in special cases like assets, where
        // they may not have a ->name value but we want to display something anyway
        foreach ($works as $work) {
            $work->use_text = $work->name;
            $work->use_image = ($work->image) ? Storage::disk('public')->url('works/'.$work->image, $work->image) : null;
        }

        return (new SelectlistTransformer)->transformSelectlist($works);

    }

}
