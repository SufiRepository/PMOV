<?php
namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\ImageUploadRequest;
use App\Models\Task;
use App\Models\StatusTask;

use App\Models\Subtask;
use App\Models\Company;
Use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


/**
 * This controller handles all actions related to Subtasks for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 */
class SubtasksController extends Controller
{

    /**
     * Returns a view that invokes the ajax tables which actually contains
     * the content for the subtasks listing, which is generated in getDatatable.
     *
     * @author  farez@mindwave.my
     * @see SubtaskController::getDatatable() method that generates the JSON response
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        // Grab all the subtasks
        $this->authorize('view', Subtask::class);
        // Show the page
        return view('subtasks/index');
    }


    /**
     * Returns a form view used to create a new Subtask.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see SubtasksController::postCreate() method that validates and stores the data
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create($id)
    {
        // $this->authorize('create', Subtask::class);
        // return view('subtasks/edit') ->with('item', new Subtask);


        $this->authorize('create', Subtask::class);

        $tasks = Task::all()->where('id','=', $id);
        $statustasks = StatusTask::all();


        return view('subtasks/edit',compact('tasks'),compact('statustasks'))
        // ->with('statuslabel_list', Helper::statusLabelList())
        // ->with('statuslabel_types', Helper::statusTypeList())
        ->with('item', new Subtask() );


    }


    /**
     * Validates and stores a new Subtask.
     *
     * @todo Check if a Form Request would work better here.
     * @author farez@mindawave.my
     * @see SubtasksController::getCreate() method that makes the form
     * @since [v1.0]
     * @param ImageUploadRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(ImageUploadRequest $request)
    {
        $this->authorize('create', Subtask::class);
        // new add by farez 27/5
        // $project = new Project;
        // $project = save();

        $subtask = new Subtask();

        $subtask->company_id                = Company::getIdForCurrentUser($request->input('company_id'));
        $subtask->user_id                   = Auth::id();
        $subtask->task_id                   = $request->input('task_id');
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
        $subtask->priority                  = $request->input('priority');

        $subtask = $request->handleImages($subtask);

        if ($subtask->save()) {
            // return redirect()->route("projects.index")->with('success', trans('admin/subtasks/message.create.success'));
            // return view('subtasks/view', compact('subtask'));
            $taskId = $subtask->task_id;

            $task = Task::find($taskId);
            // $task->subtasks =$subtask->id;
            $task->subtasks                    =$request ->input('subtasks')+1;

            $task->save();
          

            return redirect()->route('tasksreroute',['taskid'=>$taskId])->with('success', trans('admin/billings/message.create.success'));
        }
                // dd($request->all());

        return redirect()->back()->withInput()->withErrors($subtask->getErrors());
    }


    /**
     * Makes a form view to edit subtask information.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see SubtasksController::postCreate() method that validates and stores
     * @param int $subtaskId
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($subtaskId = null)
    {
        $this->authorize('update', Subtask::class);
        // Check if the subtask exists


        if (is_null($item = Subtask::find($subtaskId))) {
            // return redirect()->route('subtasks.index')->with('error', trans('admin/subtasks/message.does_not_exist'));
            return view('subtasks/view', compact('subtask'));
        }
        return view('subtasks/edit2', compact('item'))
        ->with('statuslabel_list', Helper::statusLabelList())
        ->with('statuslabel_types', Helper::statusTypeList());
    }


    /**
     * Validates and stores updated subtask data from edit form.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see SubtasksController::getEdit() method that makes the form view
     * @param ImageUploadRequest $request
     * @param int $subtaskId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @since [v1.0]
     */
    public function update(ImageUploadRequest $request, $subtaskId = null)
    {
        $this->authorize('update', Subtask::class);
        // Check if the subtask exists
        if (is_null($subtask = Subtask::find($subtaskId))) {
            return redirect()->route('projects.index')->with('error', trans('admin/subtasks/message.does_not_exist'));
        }

        // Update the subtask data
        $subtask->name                      = $request->input('name');
        $subtask->details                   = $request->input('details');
        $subtask->status_id                 = $request ->input('status_id');
        $subtask->contractor_id             = $request->input('contractor_id');    
        $subtask->supplier_id               = $request->input('supplier_id');        
        $subtask->contract_start_date       = $request->input('contract_start_date');
        $subtask->contract_end_date         = $request->input('contract_end_date');
        $subtask->actual_start_date         = $request->input('actual_start_date');
        $subtask->actual_end_date           = $request->input('actual_end_date');
        $subtask->contract_duration         = $request->input('contract_duration');
        $subtask->actual_duration           = $request->input('actual_duration');
        $subtask->priority                  = $request->input('priority');

        $subtask = $request->handleImages($subtask);


        if ($subtask->save()) {
            
            // return redirect()->route("projects.index")->with('success', trans('admin/subtasks/message.update.success'));
            // return view('subtasks/view', compact('subtask'));
            return redirect()->route('subtasks.show', ['subtask' => $subtaskId])->with('success', trans('admin/subtasks/message.update.success'));

        }
        return redirect()->back()->withInput()->withInput()->withErrors($subtask->getErrors());
    }

    /**
     * Validates and deletes selected subtask.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param int $subtaskId
     * @since [v1.0]
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($subtaskId)
    {
        $this->authorize('delete', Subtask::class);
        if (is_null($subtask = Subtask::find($subtaskId))) {
            return redirect()->route('projects.index')->with('error', trans('admin/subtasks/message.not_found'));
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

        $subtask->delete();

        $taskId = $subtask->task_id;
         

        return redirect()->route('tasksreroute',['taskid'=>$taskId])->with('success', trans('admin/subtasks/message.create.success'));
        // return redirect()->route('projects.index')->with('success',
        //     trans('admin/clients/message.delete.success')
        // );


    }

    /**
    * Returns a view that invokes the ajax tables which actually contains
    * the content for the subtasks detail page.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param int $id
    * @since [v1.0]
    * @return \Illuminate\Contracts\View\View
     */
    public function show($id = null)
    {
        $subtask = Subtask::find($id);

        if (isset($subtask->id)) {
            return view('subtasks/view', compact('subtask'));
        }

        return redirect()->route('subtasks.index')->with('error', trans('admin/subtasks/message.does_not_exist'));
    }

}
