<?php

namespace App\Http\Controllers\Api;


use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Transformers\ImplementationPlansTransformer;
use App\Http\Transformers\SelectlistTransformer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

// add by farez 28/5/2021
use App\Models\ImplementationPlan;
use App\Models\Company;
use App\Models\User;
use App\Models\Project;

class ImplementationPlansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @author farez@mindawave.my
     * @since [v4.0]
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', ImplementationPlan::class);
        $allowed_columns = [
            
            'id',
            'name',
            'details',
             
            'contract_start_date',
            'contract_end_date',
            'actual_start_date',
            'actual_end_date',

            'user_id',
            'company_id',
            'project_id',
            'status_id',
        ];

        // old code

        // $proj_access = Auth::user()->company_id;
        // $projects = Company::scopeCompanyables(Project::select('projects.*'),"company_id","projects");

        // end old code

        // new code 21/5/21

         $user_id = Auth::id();
            // $user = 
            // $projects = Project::withCount('assets as assets_count','licenses as licenses_count','accessories as accessories_count','consumables as consumables_count','components as components_count','users as users_count')
            // ->where('user.id','=',Auth::id());
        
            $implementationplans= ImplementationPlan::select('implementationplans.*') -> where('user_id','=', $user_id);
        // end new code 
        

        if ($request->input('deleted')=='true') {
            $implementationplans->onlyTrashed();
        }

        if ($request->filled('search')) {
            $implementationplans = $implementationplans->TextSearch($request->input('search'));
        }

      
        if ($request->filled('project_id')) {
            $implementationplans->where('project_id','=',$request->input('project_id'));
        }
      
        if ($request->filled('contractor_id')) {
            $implementationplans->where('contractor_id','=',$request->input('contractor_id'));
        }

        if ($request->filled('supplier_id')) {
            $implementationplans->where('supplier_id','=',$request->input('supplier_id'));
        }

        
        if ($request->filled('status_id')) {
            $implementationplans->where('implementationplans.status_id', '=', $request->input('status_id'));
        }

        // Set the offset to the API call's offset, unless the offset is higher than the actual count of items in which
        // case we override with the actual count, so we should return 0 items.
        $offset = (($implementationplans) && ($request->get('offset') > $implementationplans->count())) ? $implementationplans->count() : $request->get('offset', 0);

        // Check to make sure the limit is not higher than the max allowed
        ((config('app.max_results') >= $request->input('limit')) && ($request->filled('limit'))) ? $limit = $request->input('limit') : $limit = config('app.max_results');

        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';
        //sufi@mindwave .. disable $tasks->orderBy($sort, $order);

        $total = $implementationplans->count();
        $implementationplans = $implementationplans->skip($offset)->take($limit)->get();
        return (new ImplementationPlansTransformer)->transformImplementationPlans($implementationplans, $total);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @author farez@mindwave.my
     * @since [v4.0]
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Task::class);
        $task = new Task;
        $task->fill($request->all());

        if ($task->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $task, trans('admin/implementationplans/message.create.success')));
        }
        return response()->json(Helper::formatStandardApiResponse('error', null, $task->getErrors()));
    }

    /**
     * Display the specified resource.
     *
     * @author farez@mindwave.my
     * @since [v4.0]
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', Task::class);
        // $task = Task::withCount('assets as assets_count')->withCount('licenses as licenses_count')->withCount('consumables as consumables_count')->withCount('accessories as accessories_count')->findOrFail($id);
        return (new ImplementationPlansTransformer)->transformTask($task);
    }


    /**
     * Update the specified resource in storage.
     *
     * @author farez@mindwave.my
     * @since [v4.0]
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('update', Task::class);
        $task = Task::findOrFail($id);
        $task->fill($request->all());

        if ($task->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $task, trans('admin/implementationplans/message.update.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $task->getErrors()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @author farez@mindwave.my
     * @since [v4.0]
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $this->authorize('delete', Task::class);
        $task = Task::findOrFail($id);
        $this->authorize('delete', $manufacturer);

        if ($task->isDeletable()) {
            $task->delete();
            return response()->json(Helper::formatStandardApiResponse('success', null,  trans('admin/implementationplans/message.delete.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null,  trans('admin/implementationplans/message.assoc_users')));





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

        $implementationplans = Task::select([
            'id',
            'name',
            'image',
        ]);

        if ($request->filled('search')) {
            $implementationplans = $implementationplans->where('name', 'LIKE', '%'.$request->get('search').'%');
        }

        $implementationplans = $implementationplans->orderBy('name', 'ASC')->paginate(50);

        // Loop through and set some custom properties for the transformer to use.
        // This lets us have more flexibility in special cases like assets, where
        // they may not have a ->name value but we want to display something anyway
        foreach ($implementationplans as $implementationplans) {
            $implementationplans->use_text = $implementationplans->name;
            $implementationplans->use_image = ($implementationplans->image) ? Storage::disk('public')->url('implementationplans/'.$task->image, $implementationplans->image) : null;
        }

        return (new SelectlistTransformer)->transformSelectlist($implementationplans);

    }
}
