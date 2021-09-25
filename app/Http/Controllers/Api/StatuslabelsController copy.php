<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Transformers\AssetsTransformer;
use App\Http\Transformers\StatusActivitiesTransformer;
use App\Models\Asset;
use App\Models\StatusActivity;
use Illuminate\Http\Request;

class StatusActivitiesController extends Controller
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
        $this->authorize('view', StatusActivity::class);
        $allowed_columns = ['id','name','created_at', 'assets_count','color','default_label'];

        $statusactivities = StatusActivity::withCount('assets as assets_count');

        if ($request->filled('search')) {
            $statusactivities = $statusactivities->TextSearch($request->input('search'));
        }

        // Set the offset to the API call's offset, unless the offset is higher than the actual count of items in which
        // case we override with the actual count, so we should return 0 items.
        $offset = (($statusactivities) && ($request->get('offset') > $statusactivities->count())) ? $statusactivities->count() : $request->get('offset', 0);

        // Check to make sure the limit is not higher than the max allowed
        ((config('app.max_results') >= $request->input('limit')) && ($request->filled('limit'))) ? $limit = $request->input('limit') : $limit = config('app.max_results');

        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';
        $statusactivities->orderBy($sort, $order);

        $total = $statusactivities->count();
        $statusactivities = $statusactivities->skip($offset)->take($limit)->get();
        return (new StatusActivitiesTransformer)->transformStatusActivities($statusactivities, $total);
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
        $this->authorize('create', StatusActivity::class);
        $request->except('to_do', 'pending','done');

        if (!$request->filled('type')) {
            return response()->json(Helper::formatStandardApiResponse('error', null, ["type" => ["Status label type is required."]]),500);
        }

        $statusactivity = new StatusActivity;
        $statusactivity->fill($request->all());

        $statusType = StatusActivity::getStatusActivityTypesForDB($request->input('type'));
        $statusactivity->to_do        =  $statusType['to_do'];
        $statusactivity->pending           =  $statusType['pending'];
        $statusactivity->done          =  $statusType['done'];

        if ($statusactivity->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $statusactivity, trans('admin/statusactivities/message.create.success')));
        }
        return response()->json(Helper::formatStandardApiResponse('error', null, $statusactivity->getErrors()));

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
        $this->authorize('view', StatusActivity::class);
        $statusactivity = StatusActivity::findOrFail($id);
        return (new StatusActivitiesTransformer)->transformStatusActivity($statusactivity);
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
        $this->authorize('update', StatusActivity::class);
        $statusactivity = StatusActivity::findOrFail($id);
        
        $request->except('to_do', 'pending','done');

        if (!$request->filled('type')) {
            return response()->json(Helper::formatStandardApiResponse('error', null, 'Status label type is required.'));
        }

        $statusactivity->fill($request->all());

        $statusType = StatusActivity::getStatusActivityTypesForDB($request->input('type'));
        $statusactivity->to_do        =  $statusType['to_do'];
        $statusactivity->pending           =  $statusType['pending'];
        $statusactivity->done          =  $statusType['done'];

        if ($statusactivity->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $statusactivity, trans('admin/statusactivities/message.update.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $statusactivity->getErrors()));
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
        $this->authorize('delete', StatusActivity::class);
        $statusactivity = StatusActivity::findOrFail($id);
        $this->authorize('delete', $statusactivity);

        // Check that there are no assets associated
        if ($statusactivity->assets()->count() == 0) {
            $statusactivity->delete();
            return response()->json(Helper::formatStandardApiResponse('success', null,  trans('admin/statusactivities/message.delete.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/statusactivities/message.assoc_assets')));

    }



     /**
     * Show a count of assets by status label for pie chart
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return \Illuminate\Http\Response
     */

    public function getAssetCountByStatusActivity()
    {
        $this->authorize('view', StatusActivity::class);

        $statusactivities = StatusActivity::with('assets')
            ->groupBy('id')
            ->withCount('assets as assets_count')
            ->get();

        $labels=[];
        $points=[];
        $default_color_count = 100;

        foreach ($statusactivities as $statusactivity) {
            if ($statusactivity->assets_count > 0) {

                $labels[]=$statusactivity->name. ' ('.number_format($statusactivity->assets_count).')';
                $points[]=$statusactivity->assets_count;

                if ($statusactivity->color!='') {
                    $colors_array[] = $statusactivity->color;
                } else {
                    $colors_array[] = Helper::defaultChartColors($default_color_count);
                    $default_color_count++;
                }
            }
        }

        $result= [
            "labels" => $labels,
            "datasets" => [ [
                "data" => $points,
                "backgroundColor" => $colors_array,
                "hoverBackgroundColor" =>  $colors_array
            ]]
        ];
        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function assets(Request $request, $id)
    {
        $this->authorize('view', statusactivity::class);
        $this->authorize('index', Asset::class);
        $assets = Asset::where('status_id','=',$id)->with('assignedTo');

        $allowed_columns = [
            'id',
            'name',
        ];

        $offset = request('offset', 0);
        $limit = $request->input('limit', 50);
        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';
        $assets->orderBy($sort, $order);

        $total = $assets->count();
        $assets = $assets->skip($offset)->take($limit)->get();


        return (new AssetsTransformer)->transformAssets($assets, $total);
    }


    /**
     * Returns a boolean response based on whether the status label
     * is one that is to_do.
     *
     * This is used by the hardware create/edit view to determine whether
     * we should provide a dropdown of users for them to check the asset out to.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @return Bool
     */
    public function checkIfto_do($id) {
        $statusactivity = StatusActivity::findOrFail($id);
        if ($statusactivity->getStatusActivityType()=='to_do') {
            return '1';
        }

        return '0';
    }
}
