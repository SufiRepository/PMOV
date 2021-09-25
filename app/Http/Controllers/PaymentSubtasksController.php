<?php
namespace App\Http\Controllers;


use App\Http\Requests\ImageUploadRequest;
use App\Models\PaymentSubtask;
use App\Models\Project;
use App\Models\subtask;

use App\Models\Statuslabel;
use App\Models\Company;
Use App\Models\User;
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
 * This controller handles all actions related to  for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 */
class PaymentSubtasksController extends Controller
{

    /**
     * Returns a view that invokes the ajax tables which actually contains
     * the content for the PaymentSubtasks listing, which is generated in getDatatable.
     *
     * @see PaymentSubtasksController::getDatatable() method that generates the JSON response
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        // Grab all the PaymentSubtasks
        // $this->authorize('view', PaymentSubtask::class);
        // Show the page
        return view('paymentsubtasks/index');
    }


    /**
     * Returns a form view used to create a new PaymentSubtask.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see PaymentSubtasksController::postCreate() method that validates and stores the data
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create($id)
    {
        $this->authorize('create', PaymentSubtask::class);
      
        $subtasks = Subtask::all()->where('id','=', $id);

        return view('paymentsubtasks/edit',compact('subtasks'))
            ->with('item', new PaymentSubtask);
    }


    /**
     * Validates and stores a new PaymentSubtask.
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
        $this->authorize('create', PaymentSubtask::class);
        

        $paymentsubtask                = new PaymentSubtask();
       

        $paymentsubtask->name             = $request->input('name');
        $paymentsubtask->details          = $request->input('details');
        $paymentsubtask->costing          = $request->input('costing');


        $paymentsubtask->contractor_id       = $request->input('contractor_id');
        $paymentsubtask->supplier_id         = $request->input('supplier_id');

        $paymentsubtask->project_id                  = $request->input('project_id');
        $paymentsubtask->subtask_id       = $request->input('subtask_id');
         
        $paymentsubtask->company_id            = Company::getIdForCurrentUser($request->input('company_id'));
        $paymentsubtask->user_id               = Auth::id();

        $request->validate([

            'file' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048'
            ]);

            // purchase_order
            $purchase_order = time().'_'.$request->input('purchase_order').'.'.$request->file->getClientOriginalExtension();
            $filePath       = $request->file('file')->storeAs('paymentsubtask', $purchase_order, 'public');

            $paymentsubtask->purchase_order = time().'_'.$request->input('purchase_order').'.'.$request->file->getClientOriginalExtension();
            // $paymentsubtask->purchase_order = $request->input('purchase_order');
            $paymentsubtask->file_path = '/storage/' . $filePath;

            // delivery_order
            $delivery_order = time().'_'.$request->input('delivery_order').'.'.$request->file->getClientOriginalExtension();
            $filePathDO      = $request->file('delivery_order_file')->storeAs('paymentsubtask', $delivery_order, 'public');

            $paymentsubtask->delivery_order = time().'_'.$request->input('delivery_order').'.'.$request->file->getClientOriginalExtension();
            // $paymentsubtask->delivery_order = $request->input('delivery_order');
            $paymentsubtask->file_pathDO = '/storage/' . $filePathDO;

            //supported_documents
            $supported_documents = time().'_'.$request->input('supported_documents').'.'.$request->file->getClientOriginalExtension();
            $filePathSD       = $request->file('supported_documents')->storeAs('paymentsubtask', $supported_documents, 'public');

            $paymentsubtask->supported_documents = time().'_'.$request->input('supported_documents').'.'.$request->file->getClientOriginalExtension();
            // $paymentsubtask->supported_documents = $request->input('supported_documents');
            $paymentsubtask->file_pathSD= '/storage/' . $filePathSD;

        if ($paymentsubtask->save()) {
            // return view('implementationplans/view', compact('implementationplan'));

            $subtaskId = $paymentsubtask->subtask_id;

            $subtask = Subtask::find($subtaskId);
            // $subtask->payment  = $request->input('payment');
            $subtask->paymentsubtask_id =$paymentsubtask->id;
            $subtask->save();

            return redirect()->route('subtasksreroute',['subtaskid'=>$subtaskId])->with('success', trans('admin/paymenttasks/message.create.success'));

            // return redirect()->route("paymenttasks/view")->with('success', trans('admin/paymenttasks/message.create.success'));
        }
        return redirect()->back()->withInput()->withErrors($paymentsubtask->getErrors());
    }


    /**
     * Makes a form view to edit paymentsubtask information.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see PaymentTasksController::postCreate() method that validates and stores
     * @param int $paymentsubtaskId
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($paymentsubtaskId = null)
    {
        $this->authorize('update', PaymentSubtask::class);
        // Check if the paymentsubtask exists
        if (is_null($item = PaymentSubtask::find($paymentsubtaskId))) {
            return redirect()->route('paymentsubtasks.index')->with('error', trans('admin/paymentsubtasks/message.does_not_exist'));
        }


        return view('paymentsubtasks/edit', compact('item'));
    }


    /**
     * Validates and stores updated paymentsubtask data from edit form.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see PaymentTasksController::getEdit() method that makes the form view
     * @param ImageUploadRequest $request
     * @param int $paymentsubtaskId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @since [v1.0]
     */
    public function update(ImageUploadRequest $request, $paymentsubtaskId = null)
    {
        $this->authorize('update', PaymentSubtask::class);
        // Check if the paymentsubtask exists
        if (is_null($paymentsubtask = PaymentSubtask::find($paymentsubtaskId))) {
            return redirect()->route('projects.index')->with('error', trans('admin/paymentsubtasks/message.does_not_exist'));
        }

        // Update the paymentsubtask data
        $paymentsubtask->name             = $request->input('name');
        $paymentsubtask->details          = $request->input('details');
        $paymentsubtask->costing          = $request->input('costing');


        $paymentsubtask->contractor_id       = $request->input('contractor_id');
        $paymentsubtask->supplier_id         = $request->input('supplier_id');

        $paymentsubtask->user_id               = Auth::id();
        $paymentsubtask->company_id            = Company::getIdForCurrentUser($request->input('company_id'));

        $paymentsubtask = $request->handleImages($paymentsubtask);


        if ($paymentsubtask->save()) {
            // return redirect()->route("projects.index")->with('success', trans('admin/paymenttasks/message.update.success'));
            return redirect()->route('paymentsubtasks.show', ['paymentsubtask' => $paymentsubtaskId])->with('success', trans('admin/paymentsubtasks/message.update.success'));

        }
        return redirect()->back()->withInput()->withInput()->withErrors($paymentsubtask->getErrors());
    }

    /**
     * Validates and deletes selected paymentsubtask.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param int $paymentsubtask
     * @since [v1.0]
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($paymentsubtaskId)
    {
        $this->authorize('delete', PaymentSubtask::class);
        if (is_null($paymentsubtask = PaymentSubtask::find($paymentsubtaskId))) {
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

        $paymentsubtask->delete();
        return redirect()->route('projects.index')->with('success',
            trans('admin/clients/message.delete.success')
        );


    }

    /**
    * Returns a view that invokes the ajax tables which actually contains
    * the content for the paymentsubtasks detail page.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param int $id
    * @since [v1.0]
    * @return \Illuminate\Contracts\View\View
     */
    public function show($id = null)
    {
        $paymentsubtask = PaymentSubtask::find($id);

        if (isset($paymentsubtask->id)) {
            return view('paymentsubtasks/view', compact('paymentsubtask'));
        }

        return redirect()->route('paymentsubtasks.index')->with('error', trans('admin/paymentsubtasks/message.does_not_exist'));
    }

}
