<?php
namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\ImageUploadRequest;
use App\Models\Project;
Use App\Models\Company;
use App\Models\Asset;
use App\Models\License;
use App\Models\Location;
use App\Models\Client;
use App\Models\User;
use DB;

use App\Models\Typeproject;
use App\Models\Contractor;
use App\Models\Team;
use App\Models\Task;
Use App\Models\Supplier;
use App\Models\Sub_Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Redirect;


/**
 * This controller handles all actions related to project  for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 */
class ProjectsController extends Controller
{
    /**
     * Returns a view that invokes the ajax tables which actually contains
     * the content for the Project listing, which is generated in getDatatable.
     *
     * @author [farez] [<Farez@mindwave.my>]
     * @see Api\ProjectsController::index() method that generates the JSON response
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        Log::info('view');

        $this->authorize('index', Project::class);
          // add by farez @ 19/5/2021
          $assetcount = new Asset;
          $clientcount = new Client;
          $contractorcount = new Contractor;

          $asset_stats=null;

          $counts['client']   =  $clientcount ->count_by_company();
          $counts['contractor']   =  $contractorcount ->count_by_company();
          $counts['project'] = \App\Models\Project::count();
          $counts['supplier'] = \App\Models\Supplier::count();

        //   $counts['supplier'] = $suppliercount  ->count_by_company();

        return view('projects/index')->with('counts', $counts);
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
    public function create()
    {
        Log::info('view');

        // $role_id = null;

        $this->authorize('create', Project::class);

        $typeprojects = Typeproject::all(['id','name']);

        return view('projects/edit',compact('typeprojects'))

        ->with('item', new Project);
        // ->with(['item' => new Project, 'role_id' => $role_id]);
    }

    public function getView($id)
    {
        $projects           = $id;

        // $tasks = DB::table('tasks')
        //                     ->where('tasks.project_id','=',$projects )
        //                     ->where('tasks.status_id','=',1 )
        //                     ->leftJoin('contractors', 'tasks.contractor_id','=','contractors.id')
        //                     ->select('contractors.name as contractorName', 'tasks.*')
        //                     ->get();

        return view('projects.ganttchart');
                    // ->with(compact('tasks'))
                    // ->with(compact('projects'));
    }


    /**
     * Validates and stores the Project form data submitted from the new project form.
     *
     * @author farez@mindwave.my
     * @see ProjectsController::getCreate() method that provides the form view
     * @since [v1.0]
     * @param ImageUploadRequest $request

     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
   /**
     * Validates and stores a new Task.
     *
     * @todo Check if a Form Request would work better here.
     * @author farez@mindawave.my
     * @see ProjectsController::getCreate() method that makes the form
     * @since [v1.0]
     * @param ImageUploadRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(ImageUploadRequest $request)
    {
        // dd($request->all());
        //$this->authorize('create', Project::class);
        // new add by farez 27/5
        // $project = new Project;
        // $project = save();

        $role_id = null;

        
        // $team->save();

        $project = new Project();
        $project->company_id            = Company::getIdForCurrentUser($request->input('company_id'));
        $project->user_id               = Auth::id();

        $project->name                  = $request->input('name');
        $project->projectnumber         = $request->input('projectnumber');
        $project->value                 = Helper::ParseFloat($request->get('value'));
        $project->details               = $request->input('details');
        $project->duration              = $request->input('duration');
        $project->start_date            = $request->input('start_date');
        $project->end_date              = $request->input('end_date');
        $project->location_id           = $request->input('location_id');
        $project->client_id             = $request->input('client_id');
        $project->contractor_id         = $request->input('contractor_id');
        $project->typeproject_id        = $request->input('typeproject_id');
        $project->save();
    
        $team = new Team();
        $team->project_id              = $project->id;
        $team->company_id              = Company::getIdForCurrentUser($request->input('company_id'));
        $team->user_id                 = Auth::id();
        $team->role_id                 = 1;
        $team->save();

        //dd($team);

       
        $project = $request->handleImages($project);
        if ($project->save()) {
            
            $assetcount = new Asset;
            $licensecount = new License;
            $taskcount = new Task;
            $asset_stats=null;
            $user = new User;
            
    
            $taskpriority = DB::table('tasks')->where('project_id',$project->id )
            ->where('priority','=','High') 
            ->where('deleted_at','=',null) 
            ->count();

            $taskcompleted = DB::table('tasks')->where('project_id',$project->id )
            ->where('statustask_id','=','Completed') 
            ->where('deleted_at','=',null) 
            ->count();
    
            $taskdelayed = DB::table('tasks')->where('project_id',$project->id )
            ->where('statustask_id','=','Delayed') 
            ->where('deleted_at','=',null) 
            ->count();

            $tasktotal = DB::table('tasks')->where('project_id',$project->id )
            // ->where('statustask_id','=','Delayed') 
            ->where('deleted_at','=',null) 
            ->count();
            $issuetotal = DB::table('helpdesks')->where('project_id',$project->id)
            // ->where('statustask_id','=','Delayed') 
            ->where('deleted_at','=',null) 
            ->count();


                //$counts['asset'] = \App\Models\Asset::count();
                // $counts['license'] = \App\Models\License::assetcount();
    
                $counts['license']       = $licensecount    ->count_by_project();
                $counts['asset']         = $assetcount      ->count_by_company();
                $counts['accessory']     = \App\Models\Accessory::count();
                $counts['consumable']    = \App\Models\Consumable::count();
                $counts['project']       = \App\Models\Project::count();
                $counts['task']          = $taskcount->count_by_project();
                $counts['team']          = \App\Models\Team::count();
                // $counts['task']       = \App\Models\Task::count();
                $counts['assignwork']       = \App\Models\Assignwork::count();
    
                $counts['grand_total']   =  $counts['asset'] +  $counts['accessory'] +  $counts['license'] +  $counts['consumable'];

                // MailsController::getProject($project->name,$project->start_date, $project->end_date,$project->duration ,$project->value, $project->projectnumber  );
                
              return view('projects/view', compact('project'))
                    ->with(compact('taskpriority'))
                    ->with(compact('taskcompleted'))
                    ->with(compact('taskdelayed'))
                    ->with(compact('tasktotal'))
                    ->with(compact('issuetotal'))

                    // ->with(compact('$issuetotal'))

              ->with(['counts'=> $counts, 'role_id' => $role_id]) ;
            
            // return redirect()->route("projects.index")->with('success', trans('admin/projects/message.create.success'));
        }
        return redirect()->back();
    }

     /**
     * Returns a view that displays a form to edit a Proejct
     *
     * @author [farez] [<farez@mindwave.my>]
     * @see ProjectsController::update()
     * @param int $projectkId
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($projectId = null)
    {
        // Handles Proejct checks and permissions.
        $this->authorize('update', Project::class);

        // Check if the proejct exists
        if (!$item = Project::find($projectId)) {
            return redirect()->route('projects.show')->with('error', trans('admin/projects/message.does_not_exist'));
        }

        // Show the page
        return view('projects/edit', compact('item'));
    }


    
    /**
     * Validates and stores the project form data submitted from the edit
     * license form.
     *
     * @author farez@mindwave.my
     * @see ProjectsController::getEdit() method that provides the form view
     * @since [v1.0]
     * @param Request $request
     * @param int $licenseId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update( ImageUploadRequest $request, $projectId = null)
    {
        if (is_null($project = Project::find($projectId))) {
            return redirect()->route('projects.index')->with('error', trans('admin/projects/message.does_not_exist'));
        }

        $this->authorize('update', $project);

        $project->company_id            = Company::getIdForCurrentUser($request->input('company_id'));
        $project->user_id               = Auth::id();

        $project->name                  = $request->input('name');
        $project->projectnumber         = $request->input('projectnumber');
        $project->duration              = $request->input('duration');
        $project->details               = $request->input('details');
        $project->value                 =  Helper::ParseFloat($request->get('value'));
        $project->start_date            = $request->input('start_date');
        $project->finish_date           = $request->input('finish_date');
        $project->location_id           = $request->input('location_id');
        $project->client_id             = $request->input('client_id');
        $project->contractor_id         = $request->input('contractor_id');
        $project->typeproject_id        = $request->input('typeproject_id');
        
        $project = $request->handleImages($project);
        
        if ($project->save()) {

            $assetcount = new Asset;
            $licensecount = new License;
            $taskcount = new Task;
            $asset_stats=null;
    
                //$counts['asset'] = \App\Models\Asset::count();
                // $counts['license'] = \App\Models\License::assetcount();
    
                // $counts['task']                = $taskcount->count_by_priority();
                $counts['taskcompleted']        = $taskcount->count_by_completed();
                // $counts['delayed']             = $taskcount-> count_by_delayed();
                // $counts['total_task']          = $taskcount-> count_by_total();
        

                // $counts['grand_total']   =  $counts['asset'] +  $counts['accessory'] +  $counts['license'] +  $counts['consumable'];

            //   return view('projects/view', compact('project')) ;
            return redirect()->route('projects.show', ['project' => $projectId])
            ->with('counts', $counts)
            ->with('success', trans('admin/projects/message.update.success'));
            // return redirect()->route('projects.index', ['project' => $projectId])->with('success', trans('admin/projects/message.update.success'));
        }
        // If we can't adjust the number of seats, the error is flashed to the session by the event handler in License.php
        return redirect()->back()->withInput()->withErrors($project->getErrors());
    }


    /**
     * Deletes a project
     *
     * @author farez@mindawave.my
     * @param int $projectId
     * @since [v1.0]
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($projectId)
    { 
        $this->authorize('delete', Project::class);
        if (is_null($project = Project::find($projectId))) {
            return redirect()->route('projects.index')->with('error', trans('admin/projects/message.not_found'));
        }

        if (!$project->isDeletable()) {
            return redirect()->route('projects.index')->with('error', trans('admin/projects/message.assoc_users'));
        }

        // Soft delete the manufacturer if active, permanent delete if is already deleted
        if($project->deleted_at === NULL) {
            $project->delete();
        } else {
            $project->forceDelete();
        }
        // Redirect to the manufacturers management page
        return redirect()->route('projects.index')->with('success', trans('admin/projects/message.delete.success'));
    }

    /**
     * Returns a view that invokes the ajax tables which actually contains
     * the content for the issue helpdesk detail listing, which is generated via API.
     * This data contains a listing of all assets that belong to that helpdesks
     *
     * @author farez@mindwave.my
     * @param int $projectId
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($projectId = null)
    {
        $this->authorize('view', Project::class);
        $project = Project::find($projectId);

        // $role_id = null;

        $role_id = Team::where('user_id', Auth::id())->where('project_id', $projectId)->first();
        // dd($role_id);

        // add by farez @ 19/5/2021
        $assetcount = new Asset;
        $licensecount = new License;
        $taskcount = new Task;
        $asset_stats=null;

    
            // $counts['task']                = $taskcount->count_by_priority();
            // $counts['taskcompleted']       = $taskcount->count_by_completed();
            // $counts['delayed']             = $taskcount-> count_by_delayed();
            // $counts['total_task']          = $taskcount-> count_by_total();

            $taskpriority = DB::table('tasks')->where('project_id',$projectId)
            ->where('priority','=','High') 
            ->where('deleted_at','=',null) 
            ->count();

            $taskcompleted = DB::table('tasks')->where('project_id',$projectId)
            ->where('statustask_id','=','Completed') 
            ->where('deleted_at','=',null) 
            ->count();
    
            $taskdelayed = DB::table('tasks')->where('project_id',$projectId)
            ->where('statustask_id','=','Delayed') 
            ->where('deleted_at','=',null) 
            ->count();

            $tasktotal = DB::table('tasks')->where('project_id',$projectId)
            // ->where('statustask_id','=','Delayed') 
            ->where('deleted_at','=',null) 
            ->count();

            $issuetotal = DB::table('helpdesks')->where('project_id',$projectId)
            ->count();

            // return view('dashboard')->with('asset_stats', $asset_stats)->with('counts', $counts);


        if (isset($project->id)) {

            return view('projects/view', compact('project'))
            ->with(compact('taskpriority'))
            ->with(compact('taskcompleted'))
            ->with(compact('taskdelayed'))
            ->with(compact('tasktotal'))
            ->with(compact('issuetotal'))

            // ->with(compact('$issuetotal'))



            ->with(['role_id' => $role_id->role_id]);
            // ->with(['counts' => $counts, 'role_id' => $role_id->role_id]);

        }
        return view('projects/view', compact('project'));
        // ->with(['counts' => $counts, 'role_id' => $role_id->role_id]);

        $error = trans('admin/projects/message.does_not_exist');
        // Redirect to the user management page
        return redirect()->route('projects.index')->with('error', $error);
    }

    /**
     * Restore a given project (mark as un-deleted)
     *
     * @author farez@mindwave.my
     * @since [v4.1.15]
     * @param int $projects_id
     * @return Redirect
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function restore($projects_id)
    {
        $this->authorize('create', Project::class);
        $project = Project::onlyTrashed()->where('id',$projects_id)->first();

        if ($project) {

            // Not sure why this is necessary - it shouldn't fail validation here, but it fails without this, so....
            $project->setValidating(false);
            if ($project->restore()) {
                return redirect()->route('projects.index')->with('success', trans('admin/projects/message.restore.success'));
            }
            return redirect()->back()->with('error', 'Could not restore.');
        }
        return redirect()->back()->with('error', trans('admin/projects/message.does_not_exist'));

    }

}
