<?php

namespace App\Http\Controllers\Api;


use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Transformers\TasksTransformer;
use App\Http\Transformers\SelectlistTransformer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
//sufi@mindwave.my: added
use App\Models\Company;
use App\Models\User;
use App\Models\Project;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
// add by farez 28/5/2021
use App\Models\Location;
// add by farez 16/6//2021
use App\Models\Task;
use App\models\Client;
use App\models\Contactor;


class TasksController extends Controller
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
        $this->authorize('view', Task::class);
        $allowed_columns = [
            
            'id',
            'name',
            'details',
            'priority',
            'subtasks',

            'contract_start_date',
            'contract_end_date',
            'actual_start_date',
            'actual_end_date',
            'contract_duration',
            'actual_duration',
        
            'user_id',
            'company_id',
            'status_id',
            'contractor_id',
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
        
            $tasks= Task::select('tasks.*') 
            -> where('user_id','=', $user_id) ;
            // ->where ('team_member','=',5) ;
        // end new code 
        

        if ($request->input('deleted')=='true') {
            $tasks->onlyTrashed();
        }

        if ($request->filled('search')) {
            $tasks = $tasks->TextSearch($request->input('search'));
        }

        if ($request->filled('project_id')) {
            $tasks->where('project_id','=',$request->input('project_id'));
        }

        if ($request->filled('implementationplan_id')) {
            $tasks->where('implementationplan_id','=',$request->input('implementationplan_id'));
        }
      
        if ($request->filled('contractor_id')) {
            $tasks->where('contractor_id','=',$request->input('contractor_id'));
        }
        
        if ($request->filled('supplier_id')) {
            $tasks->where('supplier_id','=',$request->input('supplier_id'));
        }

        if ($request->filled('statustask_id')) {
            $tasks->where('statustask_id','=',$request->input('statustask_id'));
        }
     

        // Set the offset to the API call's offset, unless the offset is higher than the actual count of items in which
        // case we override with the actual count, so we should return 0 items.
        $offset = (($tasks) && ($request->get('offset') > $tasks->count())) ? $tasks->count() : $request->get('offset', 0);

        // Check to make sure the limit is not higher than the max allowed
        ((config('app.max_results') >= $request->input('limit')) && ($request->filled('limit'))) ? $limit = $request->input('limit') : $limit = config('app.max_results');

        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';
        //sufi@mindwave .. disable $tasks->orderBy($sort, $order);

        $total = $tasks->count();
        $tasks = $tasks->skip($offset)->take($limit)->get();
        return (new TasksTransformer)->transformTasks($tasks, $total);
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
            return response()->json(Helper::formatStandardApiResponse('success', $task, trans('admin/tasks/message.create.success')));
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
        return (new TasksTransformer)->transformTask($task);
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
            return response()->json(Helper::formatStandardApiResponse('success', $task, trans('admin/tasks/message.update.success')));
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
            return response()->json(Helper::formatStandardApiResponse('success', null,  trans('admin/tasks/message.delete.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null,  trans('admin/tasks/message.assoc_users')));
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

        $tasks = Task::select([
            'id',
            'name',
            'image',
        ]);

        if ($request->filled('search')) {
            $tasks = $tasks->where('name', 'LIKE', '%'.$request->get('search').'%');
        }

        $tasks = $tasks->orderBy('name', 'ASC')->paginate(50);

        // Loop through and set some custom properties for the transformer to use.
        // This lets us have more flexibility in special cases like assets, where
        // they may not have a ->name value but we want to display something anyway
        foreach ($tasks as $tasks) {
            $tasks->use_text = $tasks->name;
            $tasks->use_image = ($tasks->image) ? Storage::disk('public')->url('tasks/'.$task->image, $tasks->image) : null;
        }

        return (new SelectlistTransformer)->transformSelectlist($tasks);

    }
}
