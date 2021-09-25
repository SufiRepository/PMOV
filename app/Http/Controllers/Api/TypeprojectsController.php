<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Transformers\SelectlistTransformer;
use App\Http\Transformers\TypeprojectsTransformer;
use App\Models\Typeproject;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TypeprojectsController extends Controller
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
        $this->authorize('view', Typeproject::class);
        $allowed_columns = [ 'id',
                             'name'
                            ];
        
        $typeprojects = Typeproject::select(
                array('id','name'));



            $typeprojects = Company::scopeCompanyables($typeprojects);

        if ($request->filled('search')) {
            $typeprojects = $typeprojects->TextSearch($request->input('search'));
        }

        // Set the offset to the API call's offset, unless the offset is higher than the actual count of items in which
        // case we override with the actual count, so we should return 0 items.
        $offset = (($typeprojects) && ($request->get('offset') > $typeprojects->count())) ? $typeprojects->count() : $request->get('offset', 0);

        // Check to make sure the limit is not higher than the max allowed
        ((config('app.max_results') >= $request->input('limit')) && ($request->filled('limit'))) ? $limit = $request->input('limit') : $limit = config('app.max_results');

        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';
        $typeprojects->orderBy($sort, $order);

        $total = $typeprojects->count();
        $typeprojects = $typeprojects->skip($offset)->take($limit)->get();
        return (new TypeprojectsTransformer)->transformTypeprojects($typeprojects, $total);
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
        $this->authorize('create', Typeproject::class);
        $typeproject = new Typeproject;
        $typeproject->fill($request->all());

        if ($typeproject->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $typeproject, trans('admin/typeprojects/message.create.success')));
        }
        return response()->json(Helper::formatStandardApiResponse('error', null, $typeproject->getErrors()));

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
        $this->authorize('view', Typeproject::class);
        $typeproject = Typeproject::findOrFail($id);
        return (new TypeprojectsTransformer)->transformTypeproject($typeproject);
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
        $this->authorize('update', Typeproject::class);
        $typeproject = Typeproject::findOrFail($id);
        $typeproject->fill($request->all());

        if ($typeproject->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $typeproject, trans('admin/typeprojects/message.update.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $typeproject->getErrors()));
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
        $this->authorize('delete', Typeproject::class);
        $typeproject = Typeproject::with('asset_maintenances', 'assets', 'licenses')->withCount('asset_maintenances as asset_maintenances_count','assets as assets_count', 'licenses as licenses_count')->findOrFail($id);
        $this->authorize('delete', $typeproject);


        if ($typeproject->assets_count > 0) {
            return response()->json(Helper::formatStandardApiResponse('error', null,  trans('admin/typeprojects/message.delete.assoc_assets', ['asset_count' => (int) $typeproject->assets_count])));
        }

        if ($typeproject->asset_maintenances_count > 0) {
            return response()->json(Helper::formatStandardApiResponse('error', null,  trans('admin/typeprojects/message.delete.assoc_maintenances', ['asset_maintenances_count' => $typeproject->asset_maintenances_count])));
        }

        if ($typeproject->licenses_count > 0) {
            return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/typeprojects/message.delete.assoc_licenses', ['licenses_count' => (int) $typeproject->licenses_count])));
        }

        $typeproject->delete();
        return response()->json(Helper::formatStandardApiResponse('success', null,  trans('admin/typeprojects/message.delete.success')));

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

        $typeprojects = Typeproject::select([
            'id',
            'name',
            'image',
        ]);

        if ($request->filled('search')) {
            $typeprojects = $typeprojects->where('typeprojects.name', 'LIKE', '%'.$request->get('search').'%');
        }

        $typeprojects = $typeprojects->orderBy('name', 'ASC')->paginate(50);

        // Loop through and set some custom properties for the transformer to use.
        // This lets us have more flexibility in special cases like assets, where
        // they may not have a ->name value but we want to display something anyway
        foreach ($typeprojects as $typeproject) {
            $typeproject->use_text = $typeproject->name;
            $typeproject->use_image = ($typeproject->image) ? Storage::disk('public')->url('typeprojects/'.$typeproject->image, $typeproject->image) : null;
        }

        return (new SelectlistTransformer)->transformSelectlist($typeprojects);

    }

}
