<?php
namespace App\Http\Controllers;

use App\Http\Requests\ImageUploadRequest;
use App\Models\Helpdesk;
use App\Models\Task;
use App\Models\Project;

use App\Models\Company;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Redirect;

/**
 * This controller handles all actions related to helpdesks for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 */
class HelpdesksController extends Controller
{
    /**
     * Returns a view that invokes the ajax tables which actually contains
     * the content for the Helpdesks listing, which is generated in getDatatable.
     *
     * @author [farez] [<Farez@mindwave.my>]
     * @see Api\HelpdesksController::index() method that generates the JSON response
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('index', Helpdesk::class);
        return view('helpdesks/index');
    }


    /**
     * Returns a view that displays a form to create a new issue on helpdesk.
     *
     * @author [farez] [<farez@mindwave.my>]
     * @see helpdesksController::store()
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create($id)
    {
        $this->authorize('create', Helpdesk::class);

        $projectid = Project::all()->where('id','=', $id);

        $teams          = DB::table('teams')
                    ->where('teams.project_id','=',$projectid)
                    ->leftJoin('users', 'teams.user_id','=','users.id')
                    ->get();

        $projects = DB::table('projects')
                    ->where('id','=',$projectid )
                    ->first();

        return view('helpdesks/edit',compact('teams'))
                ->with(compact('projectid'))
                ->with('item', new Helpdesk);
    }

    /**
     * Validates and stores the data for a issue in helpdesk.
     *
     * @author [ Farez] [<farez@mindwave.my>]
     * @see HelpdesksController::create()
     * @since [v1.0]
     * @param ImageUploadRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(ImageUploadRequest $request)
    {

        $this->authorize('create', Helpdesk::class);
        $helpdesk = new Helpdesk;
        // $helpdesk = $request->handleImages($helpdesk);
        // $helpdesk->location_id      = request('location_id');

        $helpdesk->company_id       = Company::getIdForCurrentUser($request->input('company_id'));
        $helpdesk->name             = $request->input('name');
        $helpdesk->user_id          = Auth::id();
        $helpdesk->client_name      = $request->input('client');
        $helpdesk->client_phone     = $request->input('phone');
        $helpdesk->client_email     = $request->input('email');
        $helpdesk->client_address   = $request->input('address');
        $helpdesk->priority         = $request->input('priority');
        $helpdesk->status           = $request->input('status');
        $helpdesk->due_date         = $request->input('due_date');
        $helpdesk->description      = $request->input('description');

        $helpdesk->engineer         = $request->input('engineer');
        $helpdesk->solution         = $request->input('solution');
        $helpdesk->solution_status  = $request->input('status');
        $helpdesk->responded_date   = $request->input('responded_date');

        $helpdesk->project_id       = $request->input('project_id');

        if ($helpdesk->save()) {
            $projectId = $helpdesk->project_id;

            return redirect()->route('projectsreroute', ['projectid' => $projectId])->with('success', trans('admin/helpdesks/message.create.success'));
        }
        return redirect()->back()->withInput()->withErrors($helpdesk->getErrors());
    }

    /**
     * Returns a view that displays a form to edit a issue in helpdesk.
     *
     * @author [farez] [<farez@mindwave.my>]
     * @see HelpdesksController::update()
     * @param int $helpdeskId
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($helpdeskId = null)
    {
        // Handles helpdesk checks and permissions.
        // $this->authorize('update', Helpdesk::class);

        // $projectid = Project::all()->where('id','=', $id);

        // $teams          = DB::table('teams')
        //             ->where('teams.project_id','=',$projectid)
        //             ->leftJoin('users', 'teams.user_id','=','users.id')
        //             ->get();

        // $projects = DB::table('projects')
        //             ->where('id','=',$projectid )
        //             ->first();

        // // Check if the Helpdesk exists
        // if (!$item = Helpdesk::find($helpdeskId)) {
        //     return redirect()->route('helpdesks.index')->with('error', trans('admin/helpdesks/message.does_not_exist'));
        // }

        // // Show the page
        // // return view('helpdesks/edit',compact('teams'), compact('item'));
        // return view('helpdesks/edit',compact('teams'))
        //         ->with(compact('projectid'))
        //         ->with('item', new Helpdesk);

        $helpdesk = DB::table('helpdesks')
                    ->where('helpdesks.id','=',$helpdeskId )
                    ->leftJoin('users', 'helpdesks.user_id','=','users.id')
                    ->select('users.first_name as userFirst','users.last_name as userLast', 'helpdesks.*')
                    ->first();

        $projectId = $helpdesk->project_id;

        $tasks =DB::table('tasks')
                ->where('tasks.project_id','=',$projectId )
                ->where('tasks.deleted_at','=',null )
                ->get();

        if (isset($helpdesk->id)) {
            return view('helpdesks/view', compact('helpdesk'), compact('tasks'));
        }

        $error = trans('admin/helpdesks/message.does_not_exist');
        // Redirect to the user management page
        return redirect()->route('helpdesks.index')->with('error', $error);
    }


    /**
     * Validates and stores the updated issue on helpdesk data.
     *
     * @author [Farez] [<farez@mindwave.my>]
     * @see HelpdesksController::getEdit()
     * @param Request $request
     * @param int $helpdeskId
     * @return \Illuminate\Http\RedirectResponse
     * @since [v1.0]
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(ImageUploadRequest $request, $helpdeskId = null)
    {
        $this->authorize('update', Helpdesk::class);
        // Check if the Helpdesks exists
        if (is_null($helpdesk = Helpdesk::find($helpdeskId))) {
            // Redirect to the helpdesk  page
            return redirect()->route('helpdesks.index')->with('error', trans('admin/helpdesks/message.does_not_exist'));
        }

        // Save the  data
        $helpdesk->company_id       = Company::getIdForCurrentUser($request->input('company_id'));
        $helpdesk->name             = $request->input('name');
        $helpdesk->user_id          = Auth::id();
        $helpdesk->client_name      = $request->input('client');
        $helpdesk->client_phone     = $request->input('phone');
        $helpdesk->client_email     = $request->input('email');
        $helpdesk->client_address   = $request->input('address');
        $helpdesk->priority         = $request->input('priority');
        $helpdesk->status           = $request->input('status');
        $helpdesk->due_date         = $request->input('due_date');
        $helpdesk->description      = $request->input('description');

        $helpdesk->engineer         = $request->input('engineer');
        $helpdesk->solution         = $request->input('solution');
        $helpdesk->solution_status  = $request->input('status');
        $helpdesk->responded_date   = $request->input('responded_date');

        $helpdesk->project_id       = $request->input('project_id');

        if ($helpdesk->save()) {
            $projectId = $helpdesk->project_id;

            return redirect()->route('projectsreroute', ['projectid' => $projectId])->with('success', trans('admin/helpdesks/message.update.success'));
        }
        
        // Set the model's image property to null if the image is being deleted
        // if ($request->input('image_delete') == 1) {
        //     $helpdesk->image = null;
        // }

        // $helpdesk = $request->handleImages($helpdesk);

        // if ($helpdesk->save()) {
        //     return redirect()->route('helpdesks.index')->with('success', trans('admin/helpdesks/message.update.success'));
        // }
        return redirect()->back()->withInput()->withErrors($helpdesk->getErrors());
    }

    public function createTask()
    {
        // $this->authorize('create', Billing::class);
        // return view('billings/edit')
        //     ->with('item', new Billing);

        $user_company_id = Auth::user()->company_id;
        $user_id = Auth::id();

        $helpdesks = Helpdesk::where('company_id', $user_company_id)->get();

        $projects = DB::table('projects')
                    ->where('projects.company_id','=', $user_company_id)
                    -> where('projects.user_id','=', $user_id)
                    -> where('projects.deleted_at','=', NULL)
                    ->get();
                    
        // $tasks = DB::table('tasks')->where('project_id','=',$projectid )->get();

        return view('helpdesks.createtask')
        ->with(compact('projects'))
        ->with(compact('helpdesks'));
    }

    public function storeTask(Request $request)
    {
        // $this->authorize('create', Billing::class);

        $user_company_id = Auth::user()->company_id;
        $user_id = Auth::user()->id;

        $implementationplan_id = DB::table('implementationplans')
                                ->where('project_id','=', $request->input('project_id'))
                                ->where('company_id','=', $user_company_id)
                                -> where('deleted_at','=', NULL)
                                ->value('id');
                                // ->get();

        $helpdesk = new Task();
        $helpdesk->name = $request->input('task_name');
        $helpdesk->project_id = $request->input('project_id');
        $helpdesk->company_id = $user_company_id;
        $helpdesk->user_id = $user_id;

        $helpdesk->implementationplan_id = $implementationplan_id;
        $helpdesk->details = $request->input('details');

        if ($helpdesk->save()) {
            return redirect()->route('helpdesks.index')->with('success', trans('Task created Successfully'));
        }
        return redirect()->back()->withInput()->withErrors($billing->getErrors());
    }


    /**
     * Deletes a helpdesk.
     *
     * @author [farez] [<farez@mindwave.my>]
     * @param int $HelpdeskId
     * @since [v1.0]
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($helpdeskId)
    { 
        $this->authorize('delete', Helpdesk::class);
        // if (is_null($helpdesk = Helpdesk::withTrashed()->withCount('models as models_count')->find($HelpdeskId))) {
        //     return redirect()->route('helpdesks.index')->with('error', trans('admin/helpdesks/message.not_found'));
        // }

        // if (!$helpdesk->isDeletable()) {
        //     return redirect()->route('helpdesks.index')->with('error', trans('admin/helpdesks/message.assoc_users'));
        // }

        // if ($helpdesk->image) {
        //     try  {
        //         Storage::disk('public')->delete('helpdesks/'.$helpdesk->image);
        //     } catch (\Exception $e) {
        //         \Log::info($e);
        //     }
        // }

        // Soft delete the issue helpdesk if active, permanent delete if is already deleted
        // if($helpdesk->deleted_at === NULL) {
        //     $helpdesk->delete();
        // } else {
        //     $helpdesk->forceDelete();
        // }

        // $this->authorize('delete', Project::class);
        $helpdesk = Helpdesk::findOrFail($helpdeskId);
        $helpdesk->delete();

        $projectId = $helpdesk->project_id;
        // Redirect to the issue helpdesk management page
        return redirect()->route('projectsreroute', ['projectid' => $projectId])->with('success', trans('Issue deleted successfully'));
    }

    /**
     * Returns a view that invokes the ajax tables which actually contains
     * the content for the issue helpdesk detail listing, which is generated via API.
     * This data contains a listing of all assets that belong to that helpdesks
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param int $helpdeskId
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($helpdeskId = null)
    {
        $this->authorize('view', Helpdesk::class);
        // $helpdesk = Helpdesk::find($helpdeskId);

        $helpdesk = DB::table('helpdesks')
                    ->where('helpdesks.id','=',$helpdeskId )
                    ->leftJoin('users', 'helpdesks.user_id','=','users.id')
                    ->select('users.first_name as userFirst','users.last_name as userLast', 'helpdesks.*')
                    ->first();

        if (isset($helpdesk->id)) {
            return view('helpdesks/view', compact('helpdesk'));
        }

        $error = trans('admin/helpdesks/message.does_not_exist');
        // Redirect to the user management page
        return redirect()->route('helpdesks.index')->with('error', $error);
    }

    /**
     * Restore a given helpdesk (mark as un-deleted)
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.1.15]
     * @param int $helpdesks_id
     * @return Redirect
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function restore($helpdesks_id)
    {
        $this->authorize('create', Helpdesk::class);
        $helpdesk = Helpdesk::onlyTrashed()->where('id',$helpdesks_id)->first();

        if ($helpdesk) {

            // Not sure why this is necessary - it shouldn't fail validation here, but it fails without this, so....
            $helpdesk->setValidating(false);
            if ($helpdesk->restore()) {
                return redirect()->route('helpdesks.index')->with('success', trans('admin/helpdesks/message.restore.success'));
            }
            return redirect()->back()->with('error', 'Could not restore.');
        }
        return redirect()->back()->with('error', trans('admin/helpdesks/message.does_not_exist'));

    }
}
