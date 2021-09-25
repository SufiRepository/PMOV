<?php
namespace App\Http\Controllers;


use App\Http\Controllers\TasksController;
use App\Http\Requests\ImageUploadRequest;
use App\Models\PaymentTask;
use App\Models\Project;
use App\Models\Statuslabel;
use App\Models\Company;
Use App\Models\User;
Use App\Models\Task;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


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
 * This controller handles all actions related to PaymentTasks for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 */
class PaymentTasksController extends Controller
{

    /**
     * Returns a view that invokes the ajax tables which actually contains
     * the content for the paymenttasks listing, which is generated in getDatatable.
     *
     * @see PaymentTasksController::getDatatable() method that generates the JSON response
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        // Grab all the paymenttasks
        $this->authorize('view', PaymentTask::class);
        // Show the page
        return view('paymenttasks/index');
    }


    /**
     * Returns a form view used to create a new PaymentTask.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see PaymentTasksController::postCreate() method that validates and stores the data
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create($id )
    {
       $this->authorize('create', PaymentTask::class);
        // $tasks = Task::all('id','name')->find($taskId);

        $tasks = Task::all()->where('id','=', $id);

        return view('paymenttasks/edit',compact('tasks'))
            ->with('item', new PaymentTask);
    }


    /**
     * Validates and stores a new paymenttask.
     *
     * @todo Check if a Form Request would work better here.
     * @author farez@mindawave.my
     * @see PaymentTasksController::getCreate() method that makes the form
     * @since [v1.0]
     * @param ImageUploadRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(ImageUploadRequest $request)
    {
        $this->authorize('create', PaymentTask::class);

        $paymenttask                = new PaymentTask();
       
        $paymenttask->name             = $request->input('name');
        $paymenttask->details          = $request->input('details');
        $paymenttask->costing          = $request->input('costing');

        $paymenttask->contractor_id       = $request->input('contractor_id');
        $paymenttask->supplier_id         = $request->input('supplier_id');

        $paymenttask->task_id             = $request->input('task_id');
         
        $paymenttask->company_id            = Company::getIdForCurrentUser($request->input('company_id'));
        $paymenttask->user_id               = Auth::id();

        $request->validate([
            'file' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048'
            ]);

            // purchase_order
            $purchase_order = time().'_'.$request->input('purchase_order').'.'.$request->file->getClientOriginalExtension();
            $filePath       = $request->file('file')->storeAs('paymenttasks', $purchase_order, 'public');

            $paymenttask->purchase_order = time().'_'.$request->input('purchase_order').'.'.$request->file->getClientOriginalExtension();
            // $paymenttask->purchase_order = $request->input('purchase_order');
            $paymenttask->file_path = '/storage/' . $filePath;

            // delivery_order
            $delivery_order = time().'_'.$request->input('delivery_order').'.'.$request->file->getClientOriginalExtension();
            $filePathDO      = $request->file('delivery_order_file')->storeAs('paymenttasks', $delivery_order, 'public');

            $paymenttask->delivery_order = time().'_'.$request->input('delivery_order').'.'.$request->file->getClientOriginalExtension();
            // $paymenttask->delivery_order = $request->input('delivery_order');
            $paymenttask->file_pathDO = '/storage/' . $filePathDO;

            //supported_documents
            $supported_documents = time().'_'.$request->input('supported_documents').'.'.$request->file->getClientOriginalExtension();
            $filePathSD       = $request->file('supported_documents')->storeAs('paymenttasks', $supported_documents, 'public');

            $paymenttask->supported_documents = time().'_'.$request->input('supported_documents').'.'.$request->file->getClientOriginalExtension();
            // $paymenttask->supported_documents = $request->input('supported_documents');
            $paymenttask->file_pathSD= '/storage/' . $filePathSD;

            
        if ($paymenttask->save()) {
            // return view('implementationplans/view', compact('implementationplan'));
            // return redirect()->route("paymenttasks/view")->with('success', trans('admin/paymenttasks/message.create.success'));

            $taskId = $paymenttask->task_id;

            $task = Task::find($taskId);
            $task->payment  = $request->input('payment');
            $task->paymenttask_id =$paymenttask->id;
            $task->save();

            return redirect()->route('tasksreroute',['taskid'=>$taskId])->with('success', trans('admin/paymenttasks/message.create.success'));
        }
        return redirect()->back()->withInput()->withErrors($paymenttask->getErrors());
    }


    /**
     * Makes a form view to edit paymenttaskId information.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see PaymentTasksController::postCreate() method that validates and stores
     * @param int $paymenttaskId
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($paymenttaskId = null)
    {
        $this->authorize('update', PaymentTask::class);
        // Check if the paymenttask exists
        if (is_null($item = PaymentTask::find($paymenttaskId))) {
            return redirect()->route('paymenttasks.index')->with('error', trans('admin/paymenttasks/message.does_not_exist'));
        }


        return view('paymenttasks/edit', compact('item'));
    }


    /**
     * Validates and stores updated paymenttask data from edit form.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see PaymentTasksController::getEdit() method that makes the form view
     * @param ImageUploadRequest $request
     * @param int $paymenttaskId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @since [v1.0]
     */
    public function update(ImageUploadRequest $request, $paymenttaskId = null)
    {
        $this->authorize('update', PaymentTask::class);
        // Check if the PaymentTask exists
        if (is_null($paymenttask = PaymentTask::find($paymenttaskId))) {
            return redirect()->route('projects.index')->with('error', trans('admin/paymenttasks/message.does_not_exist'));
        }

        // Update the paymenttask data
        $paymenttask->name             = $request->input('name');
        $paymenttask->details          = $request->input('details');
        $paymenttask->costing          = $request->input('costing');


        $paymenttask->contractor_id       = $request->input('contractor_id');
        $paymenttask->supplier_id         = $request->input('supplier_id');

        $paymenttask->user_id               = Auth::id();
        $paymenttask->company_id            = Company::getIdForCurrentUser($request->input('company_id'));

        $paymenttask = $request->handleImages($paymenttask);


        if ($paymenttask->save()) {
            // return redirect()->route("projects.index")->with('success', trans('admin/paymenttasks/message.update.success'));
            return redirect()->route('paymenttasks.show', ['paymenttask' => $paymenttaskId])->with('success', trans('admin/paymenttasks/message.update.success'));

        }
        return redirect()->back()->withInput()->withInput()->withErrors($paymenttask->getErrors());
    }

    /**
     * Validates and deletes selected PaymentTask.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param int $paymenttask
     * @since [v1.0]
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($paymenttask)
    {
        $this->authorize('delete', PaymentTask::class);
        if (is_null($paymenttask = PaymentTask::find($paymenttaskId))) {
            return redirect()->route('projects.index')->with('error', trans('admin/clients/message.not_found'));
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

        $paymenttask->delete();
        // return redirect()->route('projects.index')->with('success',
        //     trans('admin/clients/message.delete.success')
        // );

        $taskId = $paymenttask->task_id;
        return redirect()->route('tasksreroute',['taskid'=>$taskId])->with('success', trans('admin/paymenttasks/message.delete.success'));
    }

    /**
    * Returns a view that invokes the ajax tables which actually contains
    * the content for the paymenttasks detail page.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param int $id
    * @since [v1.0]
    * @return \Illuminate\Contracts\View\View
     */
    public function show($id = null)
    {
        $paymenttask = PaymentTask::find($id);

        if (isset($paymenttask->id)) {
            return view('paymenttasks/view', compact('paymenttask'));
        }

        return redirect()->route('paymenttasks.index')->with('error', trans('admin/paymenttasks/message.does_not_exist'));
    }

}
