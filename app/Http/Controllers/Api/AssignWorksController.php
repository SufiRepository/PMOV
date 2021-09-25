<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Transformers\SelectlistTransformer;
use App\Http\Transformers\AssignworksTransformer;
use App\Models\Client;
use App\Models\Company;
use App\Models\Project;
use App\Models\Contractor;
use App\Models\User;
use App\Models\Assignwork;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssignworksController extends Controller
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
        // $this->authorize('view', Assignwork::class);
        $allowed_columns = [
            'id',
            'company_id',
            'project_id',
            'contractor_id',
            'date_submit',
            'details',
            'project_value',
            
        ];
        
        $assignworks = Assignwork::select(
                array(
                    'id',
                    'project_id',
                    'contractor_id',
                    'date_submit',
                    'details',
                    'project_value',
                    )
                );
            //     ->withCount('assets as assets_count')
            // ->withCount('licenses as licenses_count')
            // ->withCount('accessories as accessories_count');

            $assignworks = Company::scopeCompanyables($assignworks);

        if ($request->filled('search')) {
            $assignworks = $assignworks->TextSearch($request->input('search'));
        }
        // selected Contractor 
     if ($request->filled('contractor_id')) {
        $assignworks->where('contractor_id','=',$request->input('contractor_id'));
    }

       // selected Contractor 
       if ($request->filled('project_id')) {
        $assignworks->where('project_id','=',$request->input('project_id'));
    }


        // Set the offset to the API call's offset, unless the offset is higher than the actual count of items in which
        // case we override with the actual count, so we should return 0 items.
        $offset = (($assignworks) && ($request->get('offset') > $assignworks->count())) ? $assignworks->count() : $request->get('offset', 0);

        // Check to make sure the limit is not higher than the max allowed
        ((config('app.max_results') >= $request->input('limit')) && ($request->filled('limit'))) ? $limit = $request->input('limit') : $limit = config('app.max_results');

        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';
        $assignworks->orderBy($sort, $order);

        $total = $assignworks->count();
        $assignworks = $assignworks->skip($offset)->take($limit)->get();

        // return (new ContractorsTransformer)->transformContractors($contractors, $total);

        return (new AssignworksTransformer)->transformAssignworks($assignworks, $total);
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
        // $this->authorize('create', Assignwork::class);
        $assignwork = new Assignwork;
        $assignwork->fill($request->all());

        if ($assignwork->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $assignwork, trans('admin/assignworks/message.create.success')));
        }
        return response()->json(Helper::formatStandardApiResponse('error', null, $assignwork->getErrors()));

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
        // $this->authorize('view', Assignwork::class);
        $assignwork = Assignwork::findOrFail($id);
        return (new AssignworksTransformer)->transformAssignwork($assignwork);
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
        // $this->authorize('update', Assignwork::class);
        
        $assignwork = Assignwork::findOrFail($id);
        $assignwork->fill($request->all());

        if ($assignwork->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $assignwork, trans('admin/assignwork/message.update.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $assignwork->getErrors()));
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
        // $this->authorize('delete', Assignwork::class);
        $assignwork = Assignwork::with('asset_maintenances', 'assets', 'licenses')->withCount('asset_maintenances as asset_maintenances_count','assets as assets_count', 'licenses as licenses_count')->findOrFail($id);
        $this->authorize('delete', $assignwork);


        if ($assignwork->assets_count > 0) {
            return response()->json(Helper::formatStandardApiResponse('error', null,  trans('admin/assignworks/message.delete.assoc_assets', ['asset_count' => (int) $assignwork->assets_count])));
        }

        if ($assignwork->asset_maintenances_count > 0) {
            return response()->json(Helper::formatStandardApiResponse('error', null,  trans('admin/assignworks/message.delete.assoc_maintenances', ['asset_maintenances_count' => $assignwork->asset_maintenances_count])));
        }

        if ($assignwork->licenses_count > 0) {
            return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/assignworks/message.delete.assoc_licenses', ['licenses_count' => (int) $assignwork->licenses_count])));
        }

        $assignwork->delete();
        return response()->json(Helper::formatStandardApiResponse('success', null,  trans('admin/assignworks/message.delete.success')));

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

        $assignworks = Assignwork::select([
            'id',
        ]);

        if ($request->filled('search')) {
            $assignworks = $assignworks->where('assignworks.name', 'LIKE', '%'.$request->get('search').'%');
        }

        $assignworks = $assignworks->orderBy('name', 'ASC')->paginate(50);

        // Loop through and set some custom properties for the transformer to use.
        // This lets us have more flexibility in special cases like assets, where
        // they may not have a ->name value but we want to display something anyway
        foreach ($assignworks as $assignwork) {
            $assignwork->use_text = $assignwork->name;
            $assignwork->use_image = ($assignwork->image) ? Storage::disk('public')->url('assignworks/'.$assignwork->image, $assignwork->image) : null;
        }

        return (new SelectlistTransformer)->transformSelectlist($assignworks);

    }

}
