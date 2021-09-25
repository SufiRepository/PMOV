<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Transformers\SelectlistTransformer;
use App\Http\Transformers\BillQuantitiesTransformer;
use App\Models\BillQuantity;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BillQuantitiesController extends Controller
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
        $this->authorize('view', BillQuantity::class);
        $allowed_columns = [
            'id',
            'name',
            'sale_value',
            'buy_value',
            'type',
            'option',
                    'serial',
                    'modelNo',
                    'net_profit',
            // 'image',
            
        ];
        
        $billquantities = BillQuantity::select(
                array(
                    'id',
                    'name',
                    'type',
                    'option',
                    'serial',
                    'modelNo',
                    'net_profit',
                    'sale_value',
                    'buy_value',
                    'created_at',
                    'updated_at',
                    'deleted_at',

                    // 'image',
                    )
                );
            //     ->withCount('assets as assets_count')
            // ->withCount('licenses as licenses_count')
            // ->withCount('accessories as accessories_count');

            $billquantities = Company::scopeCompanyables($billquantities);

        if ($request->filled('search')) {
            $billquantities = $billquantities->TextSearch($request->input('search'));
        }

        
        if ($request->filled('project_id')) {
            $billquantities->where('project_id','=',$request->input('project_id'));
        }
        // Set the offset to the API call's offset, unless the offset is higher than the actual count of items in which
        // case we override with the actual count, so we should return 0 items.
        $offset = (($billquantities) && ($request->get('offset') > $billquantities->count())) ? $billquantities->count() : $request->get('offset', 0);

        // Check to make sure the limit is not higher than the max allowed
        ((config('app.max_results') >= $request->input('limit')) && ($request->filled('limit'))) ? $limit = $request->input('limit') : $limit = config('app.max_results');

        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';
        $billquantities->orderBy($sort, $order);

        $total = $billquantities->count();
        $billquantities = $billquantities->skip($offset)->take($limit)->get();
        return (new BillQuantitiesTransformer)->transformBillQuantities($billquantities, $total);
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
        $this->authorize('create', BillQuantity::class);
        $billquantity = new BillQuantity;
        $billquantity->fill($request->all());

        if ($billquantity->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $billquantity, trans('admin/billquantities/message.create.success')));
        }
        return response()->json(Helper::formatStandardApiResponse('error', null, $billquantity->getErrors()));

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
        $this->authorize('view', BillQuantity::class);
        $billquantity = BillQuantity::findOrFail($id);
        return (new BillQuantitiesTransformer)->transformBillQuantity($billquantity);
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
        $this->authorize('update', BillQuantity::class);
        $billquantity = BillQuantity::findOrFail($id);
        $billquantity->fill($request->all());

        if ($billquantity->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $billquantity, trans('admin/billquantities/message.update.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $billquantity->getErrors()));
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
        $this->authorize('delete', BillQuantity::class);
        $billquantity = BillQuantity::with('asset_maintenances', 'assets', 'licenses')->withCount('asset_maintenances as asset_maintenances_count','assets as assets_count', 'licenses as licenses_count')->findOrFail($id);
        $this->authorize('delete', $billquantity);


        if ($billquantity->assets_count > 0) {
            return response()->json(Helper::formatStandardApiResponse('error', null,  trans('admin/billquantities/message.delete.assoc_assets', ['asset_count' => (int) $billquantity->assets_count])));
        }

        if ($billquantity->asset_maintenances_count > 0) {
            return response()->json(Helper::formatStandardApiResponse('error', null,  trans('admin/billquantities/message.delete.assoc_maintenances', ['asset_maintenances_count' => $billquantity->asset_maintenances_count])));
        }

        if ($billquantity->licenses_count > 0) {
            return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/billquantities/message.delete.assoc_licenses', ['licenses_count' => (int) $billquantity->licenses_count])));
        }

        $billquantity->delete();
        return response()->json(Helper::formatStandardApiResponse('success', null,  trans('admin/billquantities/message.delete.success')));

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

        $billquantities = BillQuantity::select([
            'id',
            'name',
            'image',
        ]);

        if ($request->filled('search')) {
            $billquantities = $billquantities->where('billquantities.name', 'LIKE', '%'.$request->get('search').'%');
        }

        $billquantities = $billquantities->orderBy('name', 'ASC')->paginate(50);

        // Loop through and set some custom properties for the transformer to use.
        // This lets us have more flexibility in special cases like assets, where
        // they may not have a ->name value but we want to display something anyway
        foreach ($billquantities as $billquantity) {
            $billquantity->use_text = $billquantity->name;
            $billquantity->use_image = ($billquantity->image) ? Storage::disk('public')->url('billquantities/'.$billquantity->image, $billquantity->image) : null;
        }

        return (new SelectlistTransformer)->transformSelectlist($billquantities);

    }

}
