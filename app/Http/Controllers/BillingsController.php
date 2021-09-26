<?php
namespace App\Http\Controllers;

use App\Http\Controllers\TasksController;
use App\Http\Requests\ImageUploadRequest;
use App\Models\Billing;
use App\Models\Project;
use App\Models\ImplementationPlan;
use App\Models\Task;
use App\Models\Statuslabel;
use App\Models\Company;
Use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Http\Requests;

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

use Session;

/**
 * This controller handles all actions related to Billings for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 */
class BillingsController extends Controller
{

    /**
     * Returns a view that invokes the ajax tables which actually contains
     * the content for the billings listing, which is generated in getDatatable.
     *
     * @see BillingsController::getDatatable() method that generates the JSON response
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        // Grab all the billings
        $this->authorize('view', Billing::class);
        // Show the page
        return view('billings/index');
    }

    public function viewBilling($id)
    {
        $projects           = $id;
        $billings = DB::table('billings')
                    ->where('billings.project_id','=',$projects )
                    ->where('billings.deleted_at','=',NULL )
                    ->join('tasks', 'billings.task_id','=','tasks.id')
                    ->get();

        $project = DB::table('projects')
                    ->where('id','=',$projects )
                    ->first();
       
        return view('paymentschedules.viewbilling')
        ->with(compact('project'))
        ->with(compact('billings'));
    }

    /**
     * Returns a form view used to create a new Billing.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see BillingsController::postCreate() method that validates and stores the data
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create($implementationplan = null)
    {
        // $this->authorize('create', Billing::class);
        // return view('billings/edit')
        //     ->with('item', new Billing);
        $ipid =  ImplementationPlan::findOrFail($id); 

        $tasks = Task::all()->where('tasks.implementationplan_id','=', $billing)->get();;

        return view('billings.createbilling',compact('tasks'));
    }

    public function getCreate($id)
    {
        // $this->authorize('create', Billing::class);
        // return view('billings/edit')
        //     ->with('item', new Billing);
        $projectid            = $id;
        $task          = DB::table('tasks')
                        ->where('id','=',$taskid)
                        ->first();
        // $projectid         = $task->project_id;

        $project = DB::table('projects')
                    ->where('projects.id','=',$projectid )
                    ->leftJoin('clients', 'projects.client_id','=','clients.id')
                    ->select('clients.name as clientName', 'projects.*')
                    ->first();
                    
        // $tasks = DB::table('tasks')->where('project_id','=',$projectid )->get();

        return view('billings.createbilling')
        ->with(compact('project'))
        ->with(compact('task'));
    }

    public function getCreateSub($id)
    {
        // $this->authorize('create', Billing::class);
        // return view('billings/edit')
        //     ->with('item', new Billing);
        $taskid            = $id;
        $task          = DB::table('subtasks')
                        ->where('id','=',$taskid)
                        ->first();
        $projectid         = $task->project_id;

        $project = DB::table('projects')
                    ->where('projects.id','=',$projectid )
                    ->leftJoin('clients', 'projects.client_id','=','clients.id')
                    ->select('clients.name as clientName', 'projects.*')
                    ->first();
                    
        // $tasks = DB::table('tasks')->where('project_id','=',$projectid )->get();

        return view('billings.createbilling')
        ->with(compact('project'))
        ->with(compact('task'));
    }

    public function storeBilling(Request $request)
    {
       
        $billing = new Billing();
 
        $billing->project_id            = $request->input('project_id');
        $billing->task_id               = $request->input('task_id');
        $billing->task_name               = $request->input('task_name');

        $billing->billingdate          = $request->input('paymentdate');
        $billing->amount               = $request->input('amount');

        $billing->description               = $request->input('description');
        
        if ($billing->save()) {

            $projectid         = $request->input('project_id');
            return redirect()->route('openpaymentbilling',['id' => $projectid])->with('success', 'Billing successful');
        }
        return redirect()->back()->withInput()->withErrors($billing->getErrors());
    }

    /**
     * Validates and stores a new Billing.
     *
     * @todo Check if a Form Request would work better here.
     * @author farez@mindawave.my
     * @see BillingsController::getCreate() method that makes the form
     * @since [v1.0]
     * @param ImageUploadRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        // $this->authorize('create', Billing::class);

        $taskid = new Billing();
        $taskid = $request->input('task_id');
        $task = Task::find($taskid);
        $task = Task::where('id',$taskid)->first();
        $task->payment = $request->input('payment');
        
        if($task->save()){
            $billing = new Billing();
 
            $billing->project_id      = $request->input('project_id');
            $billing->task_id         = $request->input('task_id');

            // $request->validate([
            //     'file' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048'
            //     ]);

            // $invoice_name    = $request->input('invoice_no');
            // $billing->file_invoice       = $request->file('file_invoice_no')->storeAs('billings', $invoice_name, 'public');
            // $billing->invoice_no    = $request->input('invoice_no');
            
            // $deliveryorder_name    = $request->input('deliveryorder_no');
            // $billing->file_deliveryorder     = $request->file('file_deliveryorder_no')->storeAs('billings', $deliveryorder_name, 'public');
            // $billing->deliveryorder_no     = $request->input('deliveryorder_no');

            // $supportingdocument_name    = $request->input('supportingdocument');
            // if($supportingdocument_name != NULL){
                
            //     $checkfile_supportingdoc = $request->file('file_supportingdocument');
            //     if($checkfile_supportingdoc == NULL){
            //         Session::flash('message', "Required supporting document file missing");
            //         return Redirect::back(); 
            //     }else{
            //         $billing->file_supportingdocument     = $request->file('file_supportingdocument')->storeAs('billings', $supportingdocument_name, 'public');
            //         $billing->supportingdocument     = $request->input('supportingdocument');
            //     }
            // }

            // $paymentno_name    = $request->input('payment_no');
            // if($paymentno_name != NULL){
            //     $checkfile = $request->file('file_payment_no');
            //     if($checkfile == NULL){
            //         Session::flash('message', "Required payment no file missing");
            //         return Redirect::back(); 
            //     }else{
            //         $billing->file_payment_no     = $request->file('file_payment_no')->storeAs('billings', $paymentno_name, 'public');
            //         $billing->payment_no     = $request->input('payment_no');
            //     }
            // }

            // if($paymentno_name == NULL){
            //     $billing->billingstatus       = $request->input('pending');
            // }else {
            //     $billing->billingstatus       = $request->input('paid');
            // }

            $billing->billingdate       = $request->input('billingdate');
            $billing->amount            = $request->input('amount');

            $billing->payment_schedule_date          = $request->input('payment_schedule_date');
            $billing->amount_task               = $request->input('amount_task');

            $billing->description       = $request->input('description');
            $billing->billingstatus       = $request->input('pending');

        }else{
            return redirect()->back()->withInput()->withErrors($paymentschedule->getErrors());
        }

        

        if ($billing->save()) {

            $projectid         = $request->input('project_id');
            return redirect()->route('openpaymentbilling',['id' => $projectid])->with('success', 'Billing successful');
        }
        return redirect()->back()->withInput()->withErrors($billing->getErrors());
    }

    /**
     * Makes a form view to edit Billing information.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see BillingsController::postCreate() method that validates and stores
     * @param int $BillingId
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($billingId = null)
    {
        $this->authorize('update', Billing::class);
        // Check if the billing exists
        if (is_null($item = Billing::find($billingId))) {
            return redirect()->route('billings.index')->with('error', trans('admin/billings/message.does_not_exist'));
        }


        return view('billings/edit', compact('item'));
    }


    /**
     * Validates and stores updated billing data from edit form.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see BillingsController::getEdit() method that makes the form view
     * @param ImageUploadRequest $request
     * @param int $billingId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @since [v1.0]
     */
    public function update(ImageUploadRequest $request, $billingId = null)
    {
        $this->authorize('update', Billing::class);
        // Check if the billing exists
        if (is_null($billing = Billing::find($billingId))) {
            return redirect()->route('projects.index')->with('error', trans('admin/billings/message.does_not_exist'));
        }

        // Update the billing data
        $billing->name             = $request->input('name');
        $billing->task_id       = $request->input('task_id');
        $billing->details          = $request->input('details');
        $billing->costing          = $request->input('costing');
        $billing->billing_date          = $request->input('billing_date');


        if ($billing->save()) {
            return redirect()->route("projects.index")->with('success', trans('admin/billings/message.update.success'));
        }
        return redirect()->back()->withInput()->withInput()->withErrors($billing->getErrors());
    }

    /**
     * Validates and deletes selected billing.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param int $billing
     * @since [v1.0]
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($billingId)
    {
        $this->authorize('delete', Billing::class);
        if (is_null($billing = Billing::find($billingId))) {
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

        $billing->delete();
        return redirect()->route('projects.index')->with('success',
            trans('admin/clients/message.delete.success')
        );


    }

    /**
    * Returns a view that invokes the ajax tables which actually contains
    * the content for the billings detail page.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param int $id
    * @since [v1.0]
    * @return \Illuminate\Contracts\View\View
     */
    public function show($id = null)
    {
        $billing = Billing::find($id);

        if (isset($billing->id)) {
            return view('billings/view', compact('billing'));
        }

        return redirect()->route('billings.index')->with('error', trans('admin/billings/message.does_not_exist'));
    }

}
