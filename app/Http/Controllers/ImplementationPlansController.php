<?php
namespace App\Http\Controllers;


use App\Http\Requests\ImageUploadRequest;
use App\Models\ImplementationPlan;
use App\Models\Project;
use App\Models\Statuslabel;
use App\Models\StatusTask;

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
use Illuminate\Support\Facades\Log;

/**
 * This controller handles all actions related to ImplementationPlans for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 */
class ImplementationPlanscontroller extends Controller
{

    /**
     * Returns a view that invokes the ajax tables which actually contains
     * the content for the ImplementationPlans listing, which is generated in getDatatable.
     *
     * @author  farez@mindwave.my
     * @see ImplementationPlansController::getDatatable() method that generates the JSON response
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        Log::info('view');

        // Grab all the ImplementationPlans
        $this->authorize('view', ImplementationPlan::class);
        // Show the page
        return view('implementationplans/index');
    }


    /**
     * Returns a form view used to create a new implementations.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see ImplementationPlansController::postCreate() method that validates and stores the data
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create($id)
    {
        $this->authorize('create', ImplementationPlan::class);

        $statustasks = StatusTask::all();

        $projects = Project::all()->where('id','=', $id);

        return view('implementationplans/edit',compact('projects'))
        ->with(compact('statustasks'))
        ->with('statuslabel_list', Helper::statusLabelList())
        ->with('statuslabel_types', Helper::statusTypeList())
        ->with('item', new ImplementationPlan);
    }


    /**
     * Validates and stores a new Implementation plan.
     *
     * @todo Check if a Form Request would work better here.
     * @author farez@mindawave.my
     * @see ImplemtationPlansController::getCreate() method that makes the form
     * @since [v1.0]
     * @param ImageUploadRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(ImageUploadRequest $request)
    {
        $this->authorize('create', ImplementationPlan::class);
        // new add by farez 27/5
        // $project = new Project;
        // $project = save();

        $implementationplan = new ImplementationPlan();

        $implementationplan->name             = $request->input('name');
        $implementationplan->details          = $request->input('details');

        $implementationplan->contract_start_date       = $request->input('contract_start_date');
        $implementationplan->contract_end_date         = $request->input('contract_end_date');
        $implementationplan->actual_start_date         = $request->input('actual_start_date');
        $implementationplan->actual_end_date           = $request->input('actual_end_date');
        $implementationplan->contract_duration         = $request->input('contract_duration');
        $implementationplan->actual_duration           = $request->input('actual_duration');

        
        $implementationplan->supplier_id               = $request->input('supplier_id');        
        $implementationplan->contractor_id             = $request->input('contractor_id');        
        $implementationplan->project_id       = $request->input('project_id');
        $implementationplan->status_id        = $request ->input('status_id');
        $implementationplan->user_id          = Auth::id();
        $implementationplan->company_id       = Company::getIdForCurrentUser($request->input('company_id'));

        // $implementationplan->project_id = $project->id;


        $implementationplan = $request->handleImages($implementationplan);

        if ($implementationplan->save()) {

            // $implementationplan = ImplementationPlan::find($id);
           
        //     $implementationplanId = $implementationplan->id;//Check your correspond table for primary key column label is 'id'.

        // return redirect()->route('implementationplans.show', ['implementationplan' => $implementationplanId])->with('success', trans('admin/implementationplans/message.create.success'));

        $projectId = $implementationplan->project_id;

        $project = Project::find($projectId);
        $project->implementationplan_id =$implementationplan->id;
        $project->save();

        return redirect()->route('projectsreroute', ['projectid' => $projectId])->with('success',trans('admin/implementationplans/message.create.success'));
        // dd($request->all());
        }
        return redirect()->back()->withInput()->withErrors($implementationplan->getErrors());
    }


    /**
     * Makes a form view to edit implementationplan information.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see ImplementationPlansContoller::postCreate() method that validates and stores
     * @param int $ImplementationplanId
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($implementationplanId = null)
    {
        $this->authorize('update', ImplementationPlan::class);

        // $projectId = $implementationplanId;

        // $projects = Project::find($implementationplanId);

        // Check if the impementationplan exists
        if (is_null($item = ImplementationPlan::find($implementationplanId))) {
            return redirect()->route('implementationplans.index')->with('error', trans('admin/implementationplans/message.does_not_exist'));
        }


        return view('implementationplans/edit2', compact('item')) 
        // ->with('',Project::)
        // ->with(compact('project'))
         ->with('statuslabel_list', Helper::statusLabelList())
         ->with('statuslabel_types', Helper::statusTypeList());
    }


    /**
     * Validates and stores updated implementation plans data from edit form.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see ImplementationPlansController::getEdit() method that makes the form view
     * @param ImageUploadRequest $request
     * @param int $implementationplanId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @since [v1.0]
     */
     public function update(ImageUploadRequest $request, $implementationplanId = null)
    {
        $this->authorize('update', ImplementationPlan::class);
        // Check if the task exists
        if (is_null($implementationplan = ImplementationPlan::find($implementationplanId))) {
            return redirect()->route('projects.index')->with('error', trans('admin/implementationplans/message.does_not_exist'));
        }

        // Update the task data
        $implementationplan->name             = $request->input('name');
        $implementationplan->details          = $request->input('details');

        $implementationplan->contract_start_date       = $request->input('contract_start_date');
        $implementationplan->contract_end_date         = $request->input('contract_end_date');
        $implementationplan->actual_start_date         = $request->input('actual_start_date');
        $implementationplan->actual_end_date           = $request->input('actual_end_date');
        $implementationplan->contract_duration         = $request->input('contract_duration');
        $implementationplan->actual_duration           = $request->input('actual_duration');

        $implementationplan->supplier_id                = $request->input('supplier_id');        
        $implementationplan->contractor_id           = $request->input('contractor_id');        
        $implementationplan->status_id        = $request ->input('status_id');
        $implementationplan->user_id          = Auth::id();
        $implementationplan->company_id       = Company::getIdForCurrentUser($request->input('company_id'));


        $implementationplan = $request->handleImages($implementationplan);
       


        if ($implementationplan->save()) {
            // return redirect()->route("projects.index")->with('success', trans('admin/implementationplans/message.update.success'));
            return redirect()->route('implementationplans.show', ['implementationplan' => $implementationplanId])->with('success', trans('admin/implementationplans/message.update.success'));

            // return view('implementationplans/view', compact('implementationplan'));

        }
        return redirect()->back()->withInput()->withInput()->withErrors($implementationplan->getErrors());
    }
    /**
     * Validates and deletes selected implementationplan.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param int $implementationplan
     * @since [v1.0]
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($implementationplanId)
    {
        $this->authorize('delete', ImplementationPlan::class);
        if (is_null($implementationplan = ImplementationPlan::find($implementationplanId))) {
            return redirect()->route('implementationplans.index')->with('error', trans('admin/implementationplans/message.not_found'));
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

        $implementationplan->delete();
        $projectId = $implementationplan->project_id;

        return redirect()->route('projectsreroute', ['projectid' => $projectId])->with('success',trans('admin/implementationplans/message.delete.success'));

        // return redirect()->route('implementationplans.index')->with('success',trans('admin/clients/message.delete.success')

    }

    /**
    * Returns a view that invokes the ajax tables which actually contains
    * the content for the implementationplans detail page.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param int $id
    * @since [v1.0]
    * @return \Illuminate\Contracts\View\View
     */
    public function show($id = null)
    {
        $implementationplan = ImplementationPlan::find($id);

        if (isset($implementationplan->id)) {
            return view('implementationplans/view', compact('implementationplan'));
            
        }

        return redirect()->route('implementationplans.index')->with('error', trans('admin/implementationplans/message.does_not_exist'));
    }

}
