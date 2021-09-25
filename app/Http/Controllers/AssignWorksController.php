<?php
namespace App\Http\Controllers;

use App\Http\Requests\ImageUploadRequest;
use App\Models\Contractor;
use App\Models\Company;
// use App\models\user;
use App\models\project;
use App\models\Assignwork;
use App\Models\Setting;
use App\Models\Role;
use App\Models\User;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use DB;
/**
 * This controller handles all actions related to assignwork for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 */
class AssignworksController extends Controller
{
    /**
     * Show a list of all Assignworks
     *
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        // Grab all the assignwork
        // $this->authorize('view', Assignwork::class);

        
        // $counts['project'] = \App\Models\Project::count();
        // $counts['contractor'] = \App\Models\Contractor::count();
        // $counts['client'] = \App\Models\Client::count(); 
        // Show the page
        return view('assignworks/index');
        // ->with('counts', $counts);
    }


    /**
     * Assignwork create.
     *
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $roles = Role::all(['id','name']);
        $users = User::all('id','username', 'company_id')->where('company_id','=', 1);

        // $this->authorize('create', Assignwork::class);
        $contractors = Contractor::all(['id','name']);

        return view('assignworks/edit',compact('contractors'))->with('item', new Assignwork);
    }


    /**
     * assignwork create form processing.
     *
     * @param ImageUploadRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        // $this->authorize('create', Assignwork::class);

        $contractor_id = $request -> contractor_id;
        $project_id = $request -> project_id;
        $company_id =$request -> company_id;

        for($i=0; $i < count($contractor_id); $i++){
             $datasave = [
                //  'asset_tag' => $asset_tag[$i],
                 'contractor_id' => $contractor_id[$i],
                 'project_id' => $project_id,
                 'company_id' => Company::getIdForCurrentUser($request->input('company_id')),

             ];
         DB::table('assignworks')->insert($datasave);
        }


        return redirect()->route("projects.index")->with('success', trans('admin/tasks/message.create.success'));

    }

    /**
     * assignwork update.
     *
     * @param  int $assignworkId
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($assignworkId = null)
    {
        // $this->authorize('update', Assignwork::class);

        // Check if the assignwork exists

        if (is_null($item = Assignwork::find($assignworkId))) {

            // Redirect to the assignwork  page

            return redirect()->route('assignworks.index')->with('error', trans('admin/assignworks/message.does_not_exist'));
        }

        // Show the page
        return view('assignworks/edit', compact('item'));
    }

  
    /**
     * assignwork update form processing page.
     *
     * @param  int $assignrworkId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update($assignworkId, ImageUploadRequest $request)
    {
        // $this->authorize('update', Assignwork::class);

        // Check if the assigbnwork exists
        if (is_null($assignwork = Assignwork::find($assignworkId))) {

            // Redirect to the assignwork  page
            return redirect()->route('assignworks.index')->with('error', trans('admin/assignworks/message.does_not_exist'));
        }

        // Save the  data
        $assignwork->company_id           = Company::getIdForCurrentUser($request->input('company_id'));
        $assignwork->project_id           = request('project_id');
        $assignwork->contractor_id        = request('contractor_id');
        $assignwork->date_submit          = $request->input('date_submit');
        $assignwork->details              = $request->input('details');
        $assignwork->project_value        = $request->input('project_value');


      

        if ($assignwork->save()) {
            return redirect()->route('projects.index')->with('success', trans('admin/assignworks/message.update.success'));
        }

        return redirect()->back()->withInput()->withErrors($assignwork->getErrors());

    }

    /**
     * Delete the given assignwork.
     *
     * @param  int $assignworkId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($assignworkId)
    {
        // $this->authorize('delete', Assignwork::class);
        if (is_null($assignwork = Assignwork::find($assignworkId))) {
            return redirect()->route('assignworks.index')->with('error', trans('admin/assignworks/message.not_found'));
        }


        // if ($assignwork->assets_count > 0) {
        //     return redirect()->route('assignworks.index')->with('error', trans('admin/assignworks/message.delete.assoc_assets', ['asset_count' => (int) $contractor->assets_count]));
        // }

        // if ($assignwork->asset_maintenances_count > 0) {
        //     return redirect()->route('assignworks.index')->with('error', trans('admin/assignworks/message.delete.assoc_maintenances', ['asset_maintenances_count' => $contractor->asset_maintenances_count]));
        // }

        // if ($assignwork->licenses_count > 0) {
        //     return redirect()->route('assignworks.index')->with('error', trans('admin/assignworks/message.delete.assoc_licenses', ['licenses_count' => (int) $contractor->licenses_count]));
        // }

        $assignwork->delete();
        $projectId = $assignwork->project_id;

        return redirect()->route('projectsreroute', ['projectid' => $projectId]) ->with('success', trans('admin/assignworks/message.delete.success'));


    }


    /**
     *  Get the asset information to present to the assignwork view page
     *
     * @param null $assignworkId
     * @return \Illuminate\Contracts\View\View
     * @internal param int $assetId
     */
    public function show($assignworkId = null)
    {
        $assignwork = Assignwork::find($assignworkId);

        if (isset($assignwork->id)) {
                return view('assignworks/view', compact('assignwork'));
        }

        return redirect()->route('assignworks.index')->with('error', trans('admin/assignworks/message.does_not_exist'));
    }

}
