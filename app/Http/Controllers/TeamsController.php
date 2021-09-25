<?php
namespace App\Http\Controllers;


use App\Http\Requests\ImageUploadRequest;
use App\Models\Task;
use App\Models\Team;
use App\Models\Role;
use App\Models\User;
use DB;

use App\Models\Project;
use App\Models\Company;
use App\Models\Asset;
use App\Models\License;
use App\Models\Accessory;
use App\Models\Setting;
use View;
use Illuminate\Http\Request;

use App\Helpers\Helper;

use App\Models\Consumable;
use App\Models\Assignwork;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


/**
 * This controller handles all actions related to teams for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 */
class TeamsController extends Controller
{

    /**
     * Returns a view that invokes the ajax tables which actually contains
     * the content for the teams listing, which is generated in getDatatable.
     *
     * @author  farez@mindwave.my
     * @see TeamsController::getDatatable() method that generates the JSON response
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        // Grab all the Team
        $this->authorize('view', team::class);
        // Show the page
        return view('teams/index');
    }


    /**
     * Returns a form view used to create a new team.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see TeamsController::postCreate() method that validates and stores the data
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Request $request)
    {
        
        // $id = $request->get('id');
        // Project::find($request->$id);
        $roles = Role::all(['id','name']);
        
        $users = User::all('id','username','company_id');
        
        $view = View::make('teams/edit',compact('roles'),compact('users'))
            // ->with('statuslabel_list', Helper::statusLabelList())
            ->with('item', new Asset);
            // ->with('statuslabel_types', Helper::statusTypeList());

        if ($request->filled('model_id')) {
            $selected_model = AssetModel::find($request->input('model_id'));
            $view->with('selected_model', $selected_model);
        }
        
         return $view;
        // return view('hardware/edit',['id'=>$project->id]);
    }


    /**
     * Validates and stores a new Team.
     *
     * @todo Check if a Form Request would work better here.
     * @author farez@mindawave.my
     * @see TeamsController::getCreate() method that makes the form
     * @since [v1.0]
     * @param ImageUploadRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('create', Team::class);

        $role_id =$request-> role_id;
        $user_id =$request-> user_id;
        $project_id = $request -> project_id;
        $company_id =$request -> company_id;

        for($i=0; $i < count($role_id); $i++){
             $datasave = [
                //  'asset_tag' => $asset_tag[$i],
                 'role_id' => $role_id[$i],
                 'user_id' => $user_id[$i],
                 'project_id' => $project_id,
                 'company_id' => Company::getIdForCurrentUser($request->input('company_id')),

             ];
         DB::table('teams')->insert($datasave);
        }

        $projectId = $project_id;
        $project = Project::find($projectId);

        return redirect()->route('projectsreroute', ['projectid' => $projectId])->with('success',trans('admin/teams/message.create.success'));
       

    //   return redirect()->route("projects.index")->with('success', trans('admin/teams/message.create.success'));
    }
    

    /**
     * Makes a form view to edit Team information.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see TeamsController::postCreate() method that validates and stores
     * @param int $TeamId
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($teamId = null)
    {
        $this->authorize('update', team::class);
        // Check if the team exists
        if (is_null($item = Team::find($teamId))) {
            return redirect()->route('teams.index')->with('error', trans('admin/teams/message.does_not_exist'));
        }


        return view('teams/edit', compact('item'));
    }


    /**
     * Validates and stores updated team data from edit form.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see TeamsController::getEdit() method that makes the form view
     * @param ImageUploadRequest $request
     * @param int $teamId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @since [v1.0]
     */
    public function update(ImageUploadRequest $request, $teamId = null)
    {
        $this->authorize('update', Team::class);
        // Check if the team exists
        if (is_null($team = Team::find($teamId))) {
            return redirect()->route('projects.index')->with('error', trans('admin/teams/message.does_not_exist'));
        }
        

        // Update the team data
        $team->user_id      = $request->input('user_id');
  
        if ($team->saveTeam()) {
            return redirect()->route("projects.index")->with('success', trans('admin/teams/message.update.success'));
        }
        return redirect()->back()->withInput()->withInput()->withErrors($team->getErrors());
    }

    /**
     * Validates and deletes selected team.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param int $team
     * @since [v1.0]
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($teamId)
    {
        $this->authorize('delete', Team::class);
        if (is_null($team = Team::find($teamId))) {
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

        $team->delete();
        // return redirect()->route('projects.index')->with('success',trans('admin/clients/message.delete.success') );

        $projectId = $team ->project_id;
        $project = Project::find($projectId);

        return redirect()->route('projectsreroute', ['projectid' => $projectId])->with('success',trans('admin/teams/message.delete.success'));
       

    }

    /**
    * Returns a view that invokes the ajax tables which actually contains
    * the content for the teams detail page.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param int $id
    * @since [v1.0]
    * @return \Illuminate\Contracts\View\View
     */
    public function show($id = null)
    {
        $team = Team::find($id);

        if (isset($team->id)) {
            return view('teams/view', compact('team'));
        }

        return redirect()->route('teams.index')->with('error', trans('admin/teams/message.does_not_exist'));
    }

}
