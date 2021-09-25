<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Transformers\SelectlistTransformer;
use App\Http\Transformers\ContractorsTransformer;
use App\Models\Contractor;
use App\Models\company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContractorsController extends Controller
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
        $this->authorize('view', Contractor::class);
        $allowed_columns = [
            'id',
            'name',
            'address',
            'phone',
            'contact',
            'fax',
            'email',
            'image',
            // 'assets_count',
            // 'licenses_count',
            // 'accessories_count',
            'url',
            'project_id',
        ];

        
        $contractors = Contractor::select(
                array(
                    'id',
                    'name',
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
                    'project_id',
                    'notes')
                );
            //     ->withCount('assets as assets_count')
            // ->withCount('licenses as licenses_count')
            // ->withCount('accessories as accessories_count');

            $contractors = Company::scopeCompanyables($contractors);
            
        if ($request->filled('search')) {
            $contractors = $contractors->TextSearch($request->input('search'));
        }
      

        // Set the offset to the API call's offset, unless the offset is higher than the actual count of items in which
        // case we override with the actual count, so we should return 0 items.
        $offset = (($contractors) && ($request->get('offset') > $contractors->count())) ? $contractors->count() : $request->get('offset', 0);

        // Check to make sure the limit is not higher than the max allowed
        ((config('app.max_results') >= $request->input('limit')) && ($request->filled('limit'))) ? $limit = $request->input('limit') : $limit = config('app.max_results');

        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';
        $contractors->orderBy($sort, $order);

        $total = $contractors->count();
        $contractors = $contractors->skip($offset)->take($limit)->get();
        return (new ContractorsTransformer)->transformContractors($contractors, $total);
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
        $this->authorize('create', Contractor::class);
        $contractor = new Contractor;
        $contractor->fill($request->all());

        if ($contractor->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $contractor, trans('admin/contractors/message.create.success')));
        }
        return response()->json(Helper::formatStandardApiResponse('error', null, $contractor->getErrors()));

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
        $this->authorize('view', Contractor::class);
        $contractor = Contractor::findOrFail($id);
        return (new ContractorsTransformer)->transformContractor($contractor);
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
        $this->authorize('update', Contractor::class);
        $contractor = Contractor::findOrFail($id);
        $contractor->fill($request->all());

        if ($contractor->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $contractor, trans('admin/contractors/message.update.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $contractor->getErrors()));
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
        $this->authorize('delete', Contractor::class);
        $contractor = Contractor::with('asset_maintenances', 'assets', 'licenses')->withCount('asset_maintenances as asset_maintenances_count','assets as assets_count', 'licenses as licenses_count')->findOrFail($id);
        $this->authorize('delete', $contractor);


        if ($contractor->assets_count > 0) {
            return response()->json(Helper::formatStandardApiResponse('error', null,  trans('admin/contractors/message.delete.assoc_assets', ['asset_count' => (int) $contractor->assets_count])));
        }

        if ($contractor->asset_maintenances_count > 0) {
            return response()->json(Helper::formatStandardApiResponse('error', null,  trans('admin/contractors/message.delete.assoc_maintenances', ['asset_maintenances_count' => $contractor->asset_maintenances_count])));
        }

        if ($contractor->licenses_count > 0) {
            return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/contractors/message.delete.assoc_licenses', ['licenses_count' => (int) $contractor->licenses_count])));
        }

        $contractor->delete();
        return response()->json(Helper::formatStandardApiResponse('success', null,  trans('admin/contractors/message.delete.success')));

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

        $contractors = Contractor::select([
            'id',
            'name',
            'image',
        ]);

        if ($request->filled('search')) {
            $contractors = $contractors->where('contractors.name', 'LIKE', '%'.$request->get('search').'%');
        }

        $contractors = $contractors->orderBy('name', 'ASC')->paginate(50);

        // Loop through and set some custom properties for the transformer to use.
        // This lets us have more flexibility in special cases like assets, where
        // they may not have a ->name value but we want to display something anyway
        foreach ($contractors as $contractor) {
            $contractor->use_text = $contractor->name;
            $contractor->use_image = ($contractor->image) ? Storage::disk('public')->url('contractors/'.$contractor->image, $contractor->image) : null;
        }

        return (new SelectlistTransformer)->transformSelectlist($contractors);

    }

}
