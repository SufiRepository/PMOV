<?php
namespace App\Http\Controllers;

use App\Http\Controllers\TasksController;

use App\Http\Requests\ImageUploadRequest;
use App\Models\Task;
use App\Models\Project;
use App\Models\Statuslabel;
use App\Models\Company;
Use App\Models\User;
Use App\Models\Subtask;
Use App\Models\ImplementationPlan;
Use App\Models\Team;
Use App\Models\StatusTask;



use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;

use App\Helpers\Helper;
use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\CheckoutRequest;
use App\Models\Location;
use App\Models\Setting;
use Carbon\Carbon;
use DB;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Input;
use League\Csv\Reader;
use League\Csv\Statement;
use Paginator;
use Redirect;
use Response;
use Slack;
use Str;
use TCPDF;
use View;

/**
 * This controller handles all actions related to Tasks for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 */
class TasksController extends Controller
{

    /**
     * Returns a view that invokes the ajax tables which actually contains
     * the content for the tasks listing, which is generated in getDatatable.
     *
     * @author  farez@mindwave.my
     * @see TasksController::getDatatable() method that generates the JSON response
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        // Grab all the tasks
        $this->authorize('view', Task::class);
        // Show the page
        return view('tasks/index');
    }


    /**
     * Returns a form view used to create a new Task.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see TasksController::postCreate() method that validates and stores the data
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create($id){

    $this->authorize('create', Task::class);
      
    $implementationplans = ImplementationPlan::all();
        
    $projectid = Project::all()->where('id','=', $id);

    $statustasks = StatusTask::all();

    $users = User::all();

    $implementation = DB::table('implementationplans')
                    ->select('id','project_id','name')
                    ->get();

    $teams          = DB::table('teams')
                    ->where('teams.project_id','=',$projectid)
                    ->leftJoin('users', 'teams.user_id','=','users.id')
                    ->get();
                           
    $assignworks    = DB::table('assignworks')
                    ->where('assignworks.project_id','=',$projectid)
                    ->leftJoin('contractors', 'assignworks.contractor_id','=','contractors.id')
                    ->get();

    $tasks          = DB::table('tasks')
                    ->select('id','project_id','name')
                    ->where('project_id', '=', $id)
                    ->where('deleted_at', '=', NULL)
                    ->get();

        return view('tasks/edit',compact('implementationplans'),compact('teams'),compact('statustasks'),compact('tasks'))
        // ->with('statuslabel_list', Helper::statusLabelList())
        // ->with('statuslabel_types', Helper::statusTypeList())
        ->with(compact('statustasks'))
        ->with(compact('assignworks'))
        ->with(compact('tasks'))
        ->with(compact('projectid'))
        ->with(compact('implementation'))
        ->with(compact('users'))
        ->with('item', new Task);
    }


    /**
     * Validates and stores a new Task.
     *
     * @todo Check if a Form Request would work better here.
     * @author farez@mindawave.my
     * @see TasksController::getCreate() method that makes the form
     * @since [v1.0]
     * @param ImageUploadRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(ImageUploadRequest $request)
    {
        $this->authorize('create', Task::class);
        // new add by farez 27/5
        // $project = new Project;
        // $project = save();

        $task = new Task();
        $subtask = new Subtask();

        $dropdown = $request->input('maintask');

        if($dropdown == 0) {

            $task = new Task();
            $task->company_id                   = Company::getIdForCurrentUser($request->input('company_id'));
            $task->user_id                      = Auth::id();
            $task->milestone                    = $request->input('milestone', 0);
            $task->team_member                  = $request->input('team_member');
            $task->implementationplan_id        = $request->input('implementationplan_id');
            $task->project_id                   = $request->input('project_id');
            $task->type                         = $request->input('type');
            $task->manager_id                   = $request->input('manager_id');
            $task->statustask_id                = $request->input('statustask_id');
            $task->contractor_id                = $request->input('contractor_id');        
            $task->supplier_id                  = $request->input('supplier_id');        
            $task->name                         = $request->input('name');
            $task->details                      = $request->input('details');
            $task->amount_task                  = $request->input('value_task');    
            $task->payment_schedule_date        = $request->input('payment_month');        
            $task->billingOrpayment             = $request->input('billingOrpayment');   
            $task->contract_start_date          = $request->input('contract_start_date');
            $task->contract_end_date            = $request->input('contract_end_date');
            $task->actual_start_date            = $request->input('actual_start_date');
            $task->actual_end_date              = $request->input('actual_end_date');
            $task->contract_duration            = $request->input('contract_duration');
            $task->actual_duration              = $request->input('actual_duration');
            $task->priority                     = $request->input('priority');
            $task->subtasks                     =$request ->input('subtasks');

           
            $task = $request->handleImages($task);

            if($task->save()){

            // $implementationplanId = $task->implementationplan_id;

            $projectId = $task->project_id;
            $project = Project::find($projectId);
    
            return redirect()->route('projectsreroute', ['projectid' => $projectId])->with('success',trans('admin/tasks/message.create.success'));
        
            
            // return redirect()->route('impreroute', ['implementationplanid' => $implementationplanId])->with('success',trans('admin/tasks/message.create.success'));
        }
    }else{
        
        $subtask = new Subtask();
        $subtask->company_id                = Company::getIdForCurrentUser($request->input('company_id'));
        $subtask->user_id                   = Auth::id();
        $subtask->project_id                = $request->input('project_id');
        $subtask->statustask_id             = $request ->input('statustask_id');
        $subtask->contractor_id             = $request->input('contractor_id');        
        $subtask->supplier_id               = $request->input('supplier_id');        
        $subtask->amount_task               = $request->input('value_task');    
        $subtask->payment_schedule_date     = $request->input('payment_month');        
        $subtask->billingOrpayment          = $request->input('billingOrpayment');   
        $subtask->name                      = $request->input('name');
        $subtask->details                   = $request->input('details');
        $subtask->contract_start_date       = $request->input('contract_start_date');
        $subtask->contract_end_date         = $request->input('contract_end_date');
        $subtask->actual_start_date         = $request->input('actual_start_date');
        $subtask->actual_end_date           = $request->input('actual_end_date');
        $subtask->contract_duration         = $request->input('contract_duration');
        $subtask->actual_duration           = $request->input('actual_duration');
        $subtask->task_id                   = $request->input('maintask');
        $subtask->implementationplan_id     = $request->input('implementationplan_id');
        $subtask->priority                  = $request->input('priority');
        $subtask->subtasks                    =$request ->input('subtasks');



        $subtask = $request->handleImages($subtask);

        if($subtask->save()){

            // $implementationplanId = $subtask->implementationplan_id;
            $projectId = $subtask->project_id;
            $project = Project::find($projectId);

            return redirect()->route('projectsreroute', ['projectid' => $projectId])->with('success',trans('admin/tasks/message.create.success'));
        }
        
    }
        return redirect()->back()->withInput()->withErrors($task->getErrors());
    }


    /**
     * Makes a form view to edit Task information.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see TasksController::postCreate() method that validates and stores
     * @param int $TaskId
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($taskId = null)
    {
        $this->authorize('update', Task::class);
        // Check if the task exists

        $implementationplans = ImplementationPlan::all();
        $statustasks = StatusTask::all();
        $tasks = Task::all();

        
         $teams = Team::all();

        if (is_null($item = Task::find($taskId))) {
            return redirect()->route('tasks.index')->with('error', trans('admin/tasks/message.does_not_exist'));
        }


        return view('tasks/edit2', compact('item'),compact('implementationplans'),compact('teams'),compact('statustasks'),compact('tasks'))
        ->with('statuslabel_list', Helper::statusLabelList())
        ->with('statuslabel_types', Helper::statusTypeList());
    }

    /**
     * Validates and stores updated task data from edit form.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see TasksController::getEdit() method that makes the form view
     * @param ImageUploadRequest $request
     * @param int $taskId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @since [v1.0]
     */
    public function update(ImageUploadRequest $request, $taskId = null)
    {
        $this->authorize('update', Task::class);
        // Check if the task exists
        if (is_null($task = Task::find($taskId))) {
            return redirect()->route('projects.index')->with('error', trans('admin/tasks/message.does_not_exist'));
        }

        // Update the task data
        $task->manager_id           = $request->input('manager_id');
        $task->status_id            = $request->input('status_id');
        $task->contractor_id        = $request->input('contractor_id');        
        $task->supplier_id          = $request->input('supplier_id');        
        $task->name                 = $request->input('name');
        $task->details              = $request->input('details');
        $task->contract_start_date  = $request->input('contract_start_date');
        $task->contract_end_date    = $request->input('contract_end_date');
        $task->actual_start_date    = $request->input('actual_start_date');
        $task->actual_end_date      = $request->input('actual_end_date');
        $task->contract_duration    = $request->input('contract_duration');
        $task->actual_duration      = $request->input('actual_duration');
        $task->statustask_id        = $request->input('statustask_id');
        $task->priority             = $request->input('priority');
        $task                       = $request->handleImages($task);

        if ($task->save()) {

            $projectId = $task->project_id;
            $project = Project::find($projectId);

            // return redirect()->route("projects.index")->with('success', trans('admin/tasks/message.update.success'));
            return redirect()->route('projectsreroute', ['projectid' => $projectId])->with('success', trans('admin/tasks/message.update.success'));

            // return view('tasks/view', compact('task'));

        }
        return redirect()->back()->withInput()->withInput()->withErrors($task->getErrors());
    }

    /**
     * Validates and deletes selected task.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param int $task
     * @since [v1.0]
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($taskId)
    {
        $this->authorize('delete', Task::class);
        if (is_null($task = Task::find($taskId))) {
            return redirect()->route('projects.index')->with('error', trans('admin/tasks/message.not_found'));
        }


        // if ($client->assets_count > 0) {
        //     return redirect()->route('clients.index')->with('error', trans('admin/clients/message.delete.assoc_assets', ['asset_count' => (int) $client->assets_count]));
        // }

        // if ($client->asset_maintenances_count > 0) {
        //     return redirect()->route('clients.index')->with('error', trans('admin/clients/message.delete.assoc_maintenances', ['asset_maintenances_count' => $client->asset_maintenances_count]));
        // }

        // if ($client->licenses_count > 0) {
        //     return redirect()->route('clients.index')->with('error', trans('admin/clients/message.delete.assoc_licenses', ['licenses_count' => (int) $client->licenses_count]));
        // }

        $task->delete();
        $projectId = $task->project_id;
        $project = Project::find($projectId);
        // $implementationplanId = $task->implementationplan_id;

        return redirect()->route('projectsreroute', ['projectid' => $projectId])->with('success',trans('admin/tasks/message.delete.success'));

    }

    /**
    * Returns a view that invokes the ajax tables which actually contains
    * the content for the tasks detail page.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param int $id
    * @since [v1.0]
    * @return \Illuminate\Contracts\View\View
     */
    public function show($id = null)
    {
        $task = Task::find($id);

        if (isset($task->id)) {
            return view('tasks/view', compact('task'));
        }

        return redirect()->route('tasks.index')->with('error', trans('admin/tasks/message.does_not_exist'));
    }

}
