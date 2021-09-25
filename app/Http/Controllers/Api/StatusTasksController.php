<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Transformers\SelectlistTransformer;
use App\Http\Transformers\StatusTasksTransformer;
use App\Models\StatusTask;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StatusTasksController extends Controller
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
        $this->authorize('view', StatusTask::class);
        $allowed_columns = [
            'id',
            'name',
            // 'department',
            // 'address',
            // 'phone',
            // 'contact',
            // 'fax',
            // 'email',
            // 'image',
            // 'assets_count',
            // 'licenses_count',
            // 'accessories_count',
            'url'];
        
        $statustasks = StatusTask::select(
                array(
                    'id',
                    'name',
                    'company_id',
                    )
                );
            //     ->withCount('assets as assets_count')
            // ->withCount('licenses as licenses_count')
            // ->withCount('accessories as accessories_count');

            $statustasks = Company::scopeCompanyables($statustasks);

        if ($request->filled('search')) {
            $statustasks = $statustasks->TextSearch($request->input('search'));
        }

        if ($request->filled('statustask_id')) {
            $statustasks->where('statustask_id','=',$request->input('statustask_id'));
        }
        // Set the offset to the API call's offset, unless the offset is higher than the actual count of items in which
        // case we override with the actual count, so we should return 0 items.
        $offset = (($statustasks) && ($request->get('offset') > $statustasks->count())) ? $statustasks->count() : $request->get('offset', 0);

        // Check to make sure the limit is not higher than the max allowed
        ((config('app.max_results') >= $request->input('limit')) && ($request->filled('limit'))) ? $limit = $request->input('limit') : $limit = config('app.max_results');

        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';
        $statustasks->orderBy($sort, $order);

        $total = $statustasks->count();
        $statustasks = $statustasks->skip($offset)->take($limit)->get();
        return (new StatusTasksTransformer)->transformStatusTasks($statustasks, $total);
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
        $this->authorize('create', StatusTask::class);
        $statustask = new StatusTask;
        $statustask->fill($request->all());

        if ($statustask->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $statustask, trans('admin/statustasks/message.create.success')));
        }
        return response()->json(Helper::formatStandardApiResponse('error', null, $statustask->getErrors()));

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
        $this->authorize('view', StatusTask::class);
        $statustask = StatusTask::findOrFail($id);
        return (new StatusTasksTransformer)->transformStatusTask($statustask);
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
        $this->authorize('update', StatusTask::class);
        $statustask = StatusTask::findOrFail($id);
        $statustask->fill($request->all());

        if ($statustask->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $statustask, trans('admin/statustasks/message.update.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $statustask->getErrors()));
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
        $this->authorize('delete', StatusTask::class);
        $statustask = StatusTask::with('asset_maintenances', 'assets', 'licenses')->withCount('asset_maintenances as asset_maintenances_count','assets as assets_count', 'licenses as licenses_count')->findOrFail($id);
        $this->authorize('delete', $statustask);


        if ($statustask->assets_count > 0) {
            return response()->json(Helper::formatStandardApiResponse('error', null,  trans('admin/statustasks/message.delete.assoc_assets', ['asset_count' => (int) $statustask->assets_count])));
        }

        if ($statustask->asset_maintenances_count > 0) {
            return response()->json(Helper::formatStandardApiResponse('error', null,  trans('admin/statustasks/message.delete.assoc_maintenances', ['asset_maintenances_count' => $statustask->asset_maintenances_count])));
        }

        if ($statustask->licenses_count > 0) {
            return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/statustasks/message.delete.assoc_licenses', ['licenses_count' => (int) $statustask->licenses_count])));
        }

        $statustask->delete();
        return response()->json(Helper::formatStandardApiResponse('success', null,  trans('admin/statustasks/message.delete.success')));

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

        $statustasks = StatusTask::select([
            'id',
            'name',
            'image',
        ]);

        if ($request->filled('search')) {
            $statustasks = $statustasks->where('statustasks.name', 'LIKE', '%'.$request->get('search').'%');
        }

        $statustasks = $statustasks->orderBy('name', 'ASC')->paginate(50);

        // Loop through and set some custom properties for the transformer to use.
        // This lets us have more flexibility in special cases like assets, where
        // they may not have a ->name value but we want to display something anyway
        foreach ($statustasks as $statustask) {
            $statustask->use_text = $statustask->name;
            $statustask->use_image = ($statustask->image) ? Storage::disk('public')->url('statustasks/'.$statustask->image, $statustask->image) : null;
        }

        return (new SelectlistTransformer)->transformSelectlist($statustasks);

    }

}
