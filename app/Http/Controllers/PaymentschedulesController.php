<?php
namespace App\Http\Controllers;


use App\Http\Requests\ImageUploadRequest;
use App\Models\PaymentSchedule;
use App\Models\Billing;
use App\Models\Project;
use App\Models\Statuslabel;
use App\Models\Company;
use App\Models\Contractor;
Use App\Models\User;
use App\Models\ImplementationPlan;
use App\Models\Task;
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

use Session;

/**
 * This controller handles all actions related to PaymentSchedules for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 */
class PaymentSchedulesController extends Controller
{

    /**
     * Returns a view that invokes the ajax tables which actually contains
     * the content for the paymentschedules listing, which is generated in getDatatable.
     *
     * @see PaymentSchedulesController::getDatatable() method that generates the JSON response
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index($id)
    {
        // Grab all the paymentschedules
        // $this->authorize('view', PaymentSchedule::class);
        return view('paymentschedules/view');

        // Show the page
        // return view('paymentschedules/index');
    }

    public function getView($id)
    {
        $projects           = $id;

        $tasks = DB::table('tasks')
                            ->where('tasks.project_id','=',$projects )
                            -> where('tasks.deleted_at','=', NULL)
                            ->leftJoin('contractors', 'tasks.contractor_id','=','contractors.id')
                            ->select('contractors.name as contractorName', 'tasks.*')
                            ->get();

        $subtasks = DB::table('subtasks')
                            ->where('subtasks.project_id','=',$projects )
                            ->where('subtasks.deleted_at','=', NULL)
                            ->leftJoin('contractors', 'subtasks.contractor_id','=','contractors.id')
                            ->select('contractors.name as contractorName', 'subtasks.*')
                            ->get();

        $totalpayment = DB::table('paymentschedules')->sum('amount');
        $totalbilling = DB::table('billings')->sum('amount');

        return view('paymentschedules.index')
                    ->with(compact('tasks'))
                    ->with(compact('subtasks'))
                    ->with(compact('totalpayment'))
                    ->with(compact('totalbilling'))
                    ->with(compact('projects'));
    }

    public function viewPayment($id)
    {
        $projects           = $id;
        // $user_id            = Auth::id();
    
        $payments = DB::table('paymentschedules')
                            ->where('paymentschedules.project_id','=',$projects )
                            ->leftJoin('tasks', 'paymentschedules.task_id','=','tasks.id')
                            ->leftJoin('subtasks', 'paymentschedules.subtask_id','=','subtasks.id')
                            ->leftJoin('contractors', 'paymentschedules.contractor_id','=','contractors.id')
                            ->select('tasks.name as taskName','subtasks.name as subtaskName',
                                    'contractors.name as contractorName','paymentschedules.*')
                            ->get();

        $project = DB::table('projects')
                            ->where('id','=',$projects )
                            ->first();

        return view('paymentschedules.viewpayment')
                ->with(compact('project'))
                ->with(compact('payments'));
    }

    // public function viewBilling($id)
    // {
    //     $projects           = $id;
    //     $billings = DB::table('billings')->where('project_id','=',$projects )->get();

    //     return view('paymentschedules.viewbilling',compact('billings'));
    // }

    public function getPayment($id)
    {
        $taskid            = $id;
        $task          = DB::table('tasks')
                        ->where('tasks.id','=',$taskid)
                        ->leftJoin('contractors', 'tasks.contractor_id','=','contractors.id')
                        ->select('contractors.id as contractorId','contractors.name as contractorName','tasks.*')
                        ->first();

        $projectid         = $task->project_id;
        $contractorid      = $task->contractor_id;

        $project = DB::table('projects')
                    ->where('projects.id','=',$projectid )
                    ->leftJoin('clients', 'projects.client_id','=','clients.id')
                    
                    ->select('clients.name as clientName', 'projects.*')
                    ->first();

        // $contractor = DB::table('contractors')     
        //                ->where('contractors.id','=',$contractorid )
        //                 ->first(); 

        // $tasks = DB::table('tasks')->where('tasks.project_id','=',$projectid )->get();
        // if($contractorid != NULL){
        //     $contractor = DB::table('contractors')     
        //                ->where('contractors.id','=',$contractorid )
        //                 ->first();
        // }

        return view('paymentschedules.createpayment')
        ->with(compact('task'))
        ->with(compact('project'))
        ->with(compact('projectid'));
    }

    public function getPaymentSub($id)
    {
        $taskid        = $id;
        $task          = DB::table('subtasks')
                        ->where('subtasks.id','=',$taskid)
                        ->leftJoin('contractors', 'subtasks.contractor_id','=','contractors.id')
                        ->select('contractors.id as contractorId','contractors.name as contractorName','subtasks.*')
                        ->first();

        $projectid         = $task->project_id;
        $contractorid      = $task->contractor_id;

        $project = DB::table('projects')
                    ->where('projects.id','=',$projectid )
                    ->leftJoin('clients', 'projects.client_id','=','clients.id')
                    
                    ->select('clients.name as clientName', 'projects.*')
                    ->first();

        // $contractor = DB::table('contractors')     
        //                ->where('contractors.id','=',$contractorid )
        //                 ->first(); 

        // $tasks = DB::table('tasks')->where('tasks.project_id','=',$projectid )->get();
        // if($contractorid != NULL){
        //     $contractor = DB::table('contractors')     
        //                ->where('contractors.id','=',$contractorid )
        //                 ->first();
        // }

        return view('paymentschedules.createpayment')
        ->with(compact('task'))
        ->with(compact('project'))
        ->with(compact('projectid'));
    }

    public function createPayment($id)
    {
        $projectid            = $id;
        $implementationplans          = DB::table('implementationplans')
                        ->where('project_id','=',$projectid )
                        ->get();

        $project = DB::table('projects')
                        ->where('projects.id','=',$projectid )
                        ->where('projects.deleted_at','=',NULL )
                        ->leftJoin('clients', 'projects.client_id','=','clients.id')
                        ->select('clients.name as clientName', 'projects.*')
                        ->first();

        $tasks = DB::table('tasks')
                        ->where('project_id','=',$projectid )
                        ->where('deleted_at','=',NULL )
                        ->get();

        $contractors    = DB::table('contractors')
                        // ->where('project_id','=',$projectid )
                        ->get();

        return view('paymentschedules.payment')
                ->with(compact('project'))
                ->with(compact('tasks'))
                ->with(compact('contractors'))
                ->with(compact('implementationplans'));
    }

    public function createBilling($id)
    {
        $projectid            = $id;
        $implementationplans          = DB::table('implementationplans')
                        ->where('project_id','=',$projectid )
                        ->get();

        $project = DB::table('projects')
                        ->where('projects.id','=',$projectid )
                        ->leftJoin('clients', 'projects.client_id','=','clients.id')
                        ->select('clients.name as clientName', 'projects.*')
                        ->first();
        
        $tasks = DB::table('tasks')
                        ->where('project_id','=',$projectid )
                        ->where('deleted_at','=',NULL )
                        ->get();

        $contractors    = DB::table('contractors')
                        // ->where('project_id','=',$projectid )
                        ->get();

        return view('paymentschedules.createbilling')
                ->with(compact('project'))
                ->with(compact('tasks'))
                ->with(compact('contractors'))
                ->with(compact('implementationplans'));
    }

    public function storePayment(Request $request)
    {
       
        $paymentschedule = new PaymentSchedule();
 
        $paymentschedule->project_id            = $request->input('project_id');
        $paymentschedule->task_id            = $request->input('task_id');
        $paymentschedule->contractor_id         = $request->input('contractor_id');
    
        // $paymentschedule->paymentstatus      = $request->input('pending');

        $paymentschedule->paymentdate          = $request->input('paymentdate');
        $paymentschedule->amount               = $request->input('amount');

        $paymentschedule->description               = $request->input('description');
        
        if ($paymentschedule->save()) {

            $projectid         = $request->input('project_id');
            return redirect()->route('openpaymentbilling',['id' => $projectid])->with('success', 'Payment successful');
        }
        return redirect()->back()->withInput()->withErrors($paymentschedule->getErrors());
    }

   
    /**
     * Returns a form view used to create a new PaymentSchedule.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see PaymentSchedulesController::postCreate() method that validates and stores the data
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', PaymentSchedule::class);
        return view('paymentschedules/edit')
            ->with('item', new PaymentSchedule);
    }


    /**
     * Validates and stores a new PaymentSchedule.
     *
     * @todo Check if a Form Request would work better here.
     * @author farez@mindawave.my
     * @see PaymentSchedulesController::getCreate() method that makes the form
     * @since [v1.0]
     * @param ImageUploadRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        $taskid = new PaymentSchedule();
        $taskid = $request->input('task_id');
        $task = Task::find($taskid);
        $task = Task::where('id',$taskid)->first();
        $task->payment = $request->input('payment');
       
        if($task->save()){
            $paymentschedule = new PaymentSchedule();
 
            $paymentschedule->project_id            = $request->input('project_id');
            $paymentschedule->task_id               = $request->input('task_id');
            $paymentschedule->contractor_id         = $request->input('contractor_id');
    
            // $request->validate([
            //     'file' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048'
            //     ]);
            // $purchaseorder_name                          = $request->input('purchaseorder_no');
            // $paymentschedule->file_purchaseorder_no     = $request->file('file_purchaseorder_no')->storeAs('paymentschedules', $purchaseorder_name, 'public');
            // $paymentschedule->purchaseorder_no          = $request->input('purchaseorder_no');
    
            // $invoice_name    = $request->input('invoice_no');
            // $paymentschedule->file_invoice_no       = $request->file('file_invoice_no')->storeAs('paymentschedules', $invoice_name, 'public');
            // $paymentschedule->invoice_no    = $request->input('invoice_no');
            
            // $paymentreference_name    = $request->input('paymentreference_no');
            // if($paymentreference_name != NULL){
            //     $checkfile = $request->file('file_paymentreference_no');
            //     if($checkfile == NULL){
            //         Session::flash('message', "Required payment reference file missing");
            //         return Redirect::back(); 
            //     }else{
            //         $paymentschedule->file_paymentreference_no     = $request->file('file_paymentreference_no')->storeAs('paymentschedules', $paymentreference_name, 'public');
            //         $paymentschedule->paymentreference_no    = $request->input('paymentreference_no');
            //     }
            // }

            // if($paymentreference_name == NULL){
            //     $paymentschedule->paymentstatus      = $request->input('pending');
            // }else {
            //     $paymentschedule->paymentstatus       = $request->input('paid');
            // }
            $paymentschedule->paymentstatus      = $request->input('pending');

            $paymentschedule->paymentdate          = $request->input('paymentdate');
            $paymentschedule->amount               = $request->input('amount');

            $paymentschedule->payment_schedule_date          = $request->input('payment_schedule_date');
            $paymentschedule->amount_task               = $request->input('amount_task');

            $paymentschedule->description               = $request->input('description');

        }else{
            return redirect()->back()->withInput()->withErrors($paymentschedule->getErrors());
        }
        

        if ($paymentschedule->save()) {

            $projectid         = $request->input('project_id');
            return redirect()->route('openpaymentbilling',['id' => $projectid])->with('success', 'Payment successful');
        }
        return redirect()->back()->withInput()->withErrors($paymentschedule->getErrors());
    }


    /**
     * Makes a form view to edit PaymentSchedule information.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see PaymentSchedulesController::postCreate() method that validates and stores
     * @param int $PaymentScheduleId
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($paymentscheduleId = null)
    {
        $this->authorize('update', PaymentSchedule::class);
        // Check if the paymentschedule exists
        if (is_null($item = PaymentSchedule::find($paymentscheduleId))) {
            return redirect()->route('paymentschedules.index')->with('error', trans('admin/paymentschedules/message.does_not_exist'));
        }


        return view('paymentschedules/edit', compact('item'));
    }


    /**
     * Validates and stores updated paymentschedule data from edit form.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see PaymentSchedulesController::getEdit() method that makes the form view
     * @param ImageUploadRequest $request
     * @param int $paymentscheduleId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @since [v1.0]
     */
    public function update(ImageUploadRequest $request, $paymentscheduleId = null)
    {
        $this->authorize('update', PaymentSchedule::class);
        // Check if the paymentschedule exists
        if (is_null($paymentschedule = PaymentSchedule::find($paymentscheduleId))) {
            return redirect()->route('projects.index')->with('error', trans('admin/paymentschedules/message.does_not_exist'));
        }

        // Update the paymentschedule data
        $paymentschedule->name             = $request->input('name');
        $paymentschedule->details          = $request->input('details');
        $paymentschedule->costing          = $request->input('costing');
        
        $paymentschedule->contractor_id       = $request->input('contractor_id');
        $paymentschedule->supplier_id         = $request->input('supplier_id');

        $paymentschedule->user_id               = Auth::id();
        $paymentschedule->company_id            = Company::getIdForCurrentUser($request->input('company_id'));

        $paymentschedule = $request->handleImages($paymentschedule);


        if ($paymentschedule->save()) {
            // return redirect()->route("projects.index")->with('success', trans('admin/paymentschedules/message.update.success'));
            return redirect()->route('paymentschedules.show', ['paymentschedule' => $paymentscheduleId])->with('success', trans('admin/paymentschedules/message.update.success'));

        }
        return redirect()->back()->withInput()->withInput()->withErrors($paymentschedule->getErrors());
    }

    /**
     * Validates and deletes selected paymentschedule.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param int $paymentschedule
     * @since [v1.0]
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($paymentscheduleId)
    {
        $this->authorize('delete', PaymentSchedule::class);
        if (is_null($paymentschedule = PaymentSchedule::find($paymentscheduleId))) {
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

        $paymentschedule->delete();

        $implementationplanId = $paymentschedule->implementationplan_id;

        return redirect()->route('impreroute', ['implementationplanid' => $implementationplanId])->with('success',trans('admin/paymentschedules/message.delete.success'));
    }

    /**
    * Returns a view that invokes the ajax tables which actually contains
    * the content for the paymentschedules detail page.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param int $id
    * @since [v1.0]
    * @return \Illuminate\Contracts\View\View
     */
    public function show($id = null)
    {
        // $paymentschedule = PaymentSchedule::find($id);

        // if (isset($paymentschedule->id)) {
        //     return view('paymentschedules/view', compact('paymentschedule'));
        // }
        return view('paymentschedules/view');
        // return redirect()->route('paymentschedules.index')->with('error', trans('admin/paymentschedules/message.does_not_exist'));
    }

}
