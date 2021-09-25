<?php

namespace App\Http\Controllers\Api;


use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Transformers\SubtasksTransformer;
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
use App\Models\Subtask;
use App\models\Task;
use App\models\Contactor;


class SubtasksController extends Controller
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
        $this->authorize('view', Subtask::class);
        $allowed_columns = [
            
            'id',
            'name',
            'details',
            'priority',
            'contract_start_date',
            'contract_end_date',
            'actual_start_date',
            'actual_end_date',
            'contract_duration',
            'actual_duration',

            'user_id',
            'company_id',
            'activity_id',
            'status_id',
            'contractor_id',
            'task_id',
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
        
            $subtasks= Subtask::select('subtasks.*') -> where('user_id','=', $user_id);
        // end new code 
        

        if ($request->input('deleted')=='true') {
            $tasks->onlyTrashed();
        }

        if ($request->filled('search')) {
            $subtasks = $subtasks->TextSearch($request->input('search'));
        }

      
        if ($request->filled('project_id')) {
            $subtasks->where('project_id','=',$request->input('project_id'));
        }
      
        if ($request->filled('task_id')) {
            $subtasks->where('task_id','=',$request->input('task_id'));
        }

        if ($request->filled('contractor_id')) {
            $subtasks->where('contractor_id','=',$request->input('contractor_id'));
        }
 
        if ($request->filled('supplier_id')) {
            $subtasks->where('supplier_id','=',$request->input('supplier_id'));
        }
       
    
        if ($request->filled('statustask_id')) {
            $subtasks->where('statustask_id','=',$request->input('statustask_id'));
        }

        // Set the offset to the API call's offset, unless the offset is higher than the actual count of items in which
        // case we override with the actual count, so we should return 0 items.
        $offset = (($subtasks) && ($request->get('offset') > $subtasks->count())) ? $subtasks->count() : $request->get('offset', 0);

        // Check to make sure the limit is not higher than the max allowed
        ((config('app.max_results') >= $request->input('limit')) && ($request->filled('limit'))) ? $limit = $request->input('limit') : $limit = config('app.max_results');

        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';
        //sufi@mindwave .. disable $subtasks->orderBy($sort, $order);

        $total = $subtasks->count();
        $subtasks = $subtasks->skip($offset)->take($limit)->get();
        return (new SubtasksTransformer)->transformSubtasks($subtasks, $total);
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
        $this->authorize('create', Subtask::class);
        $subtask = new Subtask;
        $subtask->fill($request->all());

        if ($subtask->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $subtask, trans('admin/subtasks/message.create.success')));
        }
        return response()->json(Helper::formatStandardApiResponse('error', null, $subtask->getErrors()));
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
        $this->authorize('view', Subtask::class);
        // $task = Task::withCount('assets as assets_count')->withCount('licenses as licenses_count')->withCount('consumables as consumables_count')->withCount('accessories as accessories_count')->findOrFail($id);
        return (new SubtasksTransformer)->transformSubtask($subtask);
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
        $this->authorize('update', Subtask::class);
        $subtask = Subtask::findOrFail($id);
        $subtask->fill($request->all());

        if ($subtask->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $subtask, trans('admin/subtasks/message.update.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $subtask->getErrors()));
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

        $this->authorize('delete', Subtask::class);
        $subtask = Subtask::findOrFail($id);
        $this->authorize('delete', $subtask);

        if ($subtask->isDeletable()) {
            $subtask->delete();
            return response()->json(Helper::formatStandardApiResponse('success', null,  trans('admin/subtasks/message.delete.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null,  trans('admin/subtasks/message.assoc_users')));





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

        $subtasks = Subtask::select([
            'id',
            'name',
            'image',
        ]);

        if ($request->filled('search')) {
            $subtasks = $subtasks->where('name', 'LIKE', '%'.$request->get('search').'%');
        }

        $subtasks = $subtasks->orderBy('name', 'ASC')->paginate(50);

        // Loop through and set some custom properties for the transformer to use.
        // This lets us have more flexibility in special cases like assets, where
        // they may not have a ->name value but we want to display something anyway
        foreach ($subtasks as $subtasks) {
            $subtasks->use_text = $subtasks->name;
            $subtasks->use_image = ($subtasks->image) ? Storage::disk('public')->url('subtasks/'.$task->image, $subtasks->image) : null;
        }

        return (new SelectlistTransformer)->transformSelectlist($subtasks);

    }
}
