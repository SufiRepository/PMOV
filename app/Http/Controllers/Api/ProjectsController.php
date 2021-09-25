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
use App\Http\Transformers\ProjectsTransformer;
//sufi@mindwave.my: added
use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
// add by farez 28/5/2021
use App\Models\Location;
// add by farez 16/6//2021
use App\models\Contactor;

class ProjectsController extends Controller
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
        $this->authorize('view', Project::class);
        $allowed_columns = [

            'id',

            'name',
            'projectnumber',
            'costing', 
            'value',
            'details',
            'duration',

            'finish_date',
            'end_date',
            'created_at',
            'deleted_at',
            'start_date', 
            
            
            'location_id',
            'client_id',
            'contractor_id',
            'typeproject_id',
            'company_id',
            'user_id',

            'image'
        
        ];
        
        $projects = Project::select(
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
            
            'image'

            )
                );
            //     ->withCount('assets as assets_count')
            // ->withCount('licenses as licenses_count')
            // ->withCount('accessories as accessories_count');

            // $projects = Company::scopeCompanyables($project);
// old code

        // $proj_access = Auth::user()->company_id;
        // $projects = Company::scopeCompanyables(Project::select('projects.*'),"company_id","projects");

        // end old code

        // new code 21/5/21

        $user_id = Auth::id();
        // $user = 
        // $projects = Project::withCount('assets as assets_count','licenses as licenses_count','accessories as accessories_count','consumables as consumables_count','components as components_count','users as users_count')
        // ->where('user.id','=',Auth::id());
    
        $projects= Project::select('projects.*') -> where('user_id','=', $user_id);
    // end new code 
    

    if ($request->input('deleted')=='true') {
        $projects->onlyTrashed();
    }

    if ($request->filled('search')) {
        $projects = $projects->TextSearch($request->input('search'));
    }

    // untuk select view dekat spesific view
    if ($request->filled('location_id')) {
        $projects->where('location_id','=',$request->input('location_id'));
    }
    // end view

    // selected client on project
    if ($request->filled('client_id')) {
        $projects->where('client_id','=',$request->input('client_id'));
    }

     // selected Contractor on project
     if ($request->filled('contractor_id')) {
        $projects->where('contractor_id','=',$request->input('contractor_id'));
    }

    

    // Set the offset to the API call's offset, unless the offset is higher than the actual count of items in which
    // case we override with the actual count, so we should return 0 items.
    $offset = (($projects) && ($request->get('offset') > $projects->count())) ? $projects->count() : $request->get('offset', 0);

    // Check to make sure the limit is not higher than the max allowed
    ((config('app.max_results') >= $request->input('limit')) && ($request->filled('limit'))) ? $limit = $request->input('limit') : $limit = config('app.max_results');

    $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
    $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';
    //sufi@mindwave .. disable $projects->orderBy($sort, $order);

    $total = $projects->count();
    $projects = $projects->skip($offset)->take($limit)->get();
    return (new ProjectsTransformer)->transformProjects($projects, $total);

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
        $this->authorize('create', Project::class);
        $project = new Project;
        $project->fill($request->all());

        if ($project->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $project, trans('admin/projects/message.create.success')));
        }
        return response()->json(Helper::formatStandardApiResponse('error', null, $project->getErrors()));

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
        $this->authorize('view', Project::class);
        $project = Project::findOrFail($id);
        return (new ProjectsTransformer)->transformProject($project);
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
        $this->authorize('update', Project::class);
        $project = Project::findOrFail($id);
        $project->fill($request->all());

        if ($project->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $project, trans('admin/projects/message.update.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $project->getErrors()));
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
        $this->authorize('delete', Project::class);
        $project = Project::with('asset_maintenances', 'assets', 'licenses')->withCount('asset_maintenances as asset_maintenances_count','assets as assets_count', 'licenses as licenses_count')->findOrFail($id);
        $this->authorize('delete', $project);


        if ($project->assets_count > 0) {
            return response()->json(Helper::formatStandardApiResponse('error', null,  trans('admin/projects/message.delete.assoc_assets', ['asset_count' => (int) $project->assets_count])));
        }

        if ($project->asset_maintenances_count > 0) {
            return response()->json(Helper::formatStandardApiResponse('error', null,  trans('admin/projects/message.delete.assoc_maintenances', ['asset_maintenances_count' => $project->asset_maintenances_count])));
        }

        if ($project->licenses_count > 0) {
            return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/projects/message.delete.assoc_licenses', ['licenses_count' => (int) $project->licenses_count])));
        }

        $project->delete();
        return response()->json(Helper::formatStandardApiResponse('success', null,  trans('admin/projects/message.delete.success')));

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

        $projects = Project::select([
            'id',
            'name',
            'image',
        ]);

        if ($request->filled('search')) {
            $projects = $projects->where('projects.name', 'LIKE', '%'.$request->get('search').'%');
        }

        $projects = $projects->orderBy('name', 'ASC')->paginate(50);

        // Loop through and set some custom properties for the transformer to use.
        // This lets us have more flexibility in special cases like assets, where
        // they may not have a ->name value but we want to display something anyway
        foreach ($projects as $project) {
            $project->use_text = $project->name;
            $project->use_image = ($project->image) ? Storage::disk('public')->url('projects/'.$project->image, $project->image) : null;
        }

        return (new SelectlistTransformer)->transformSelectlist($projects);

    }

}
