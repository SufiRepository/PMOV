<?php
namespace App\Http\Controllers;

use App\Http\Requests\ImageUploadRequest;
use App\Models\Role;
// use App\Models\Task;
use App\Models\Typeproject;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

/**
 * This controller handles all actions related to Role for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 */
class RolesController extends Controller
{
    /**
     * Show a list of all roles
     *
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        // Grab all the roles
        $this->authorize('view', Role::class);

        // Show the page
        return view('roles/index');
    }


    /**
     * role create.
     *
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        Log::info('view');

        $this->authorize('create', Role::class);

        $typeprojects = Typeproject::all(['id','name']);

        return view('roles/edit',compact('typeprojects'))

        ->with('item', new Role);
    }



    /**
     * role create form processing.
     *
     * @param ImageUploadRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(ImageUploadRequest $request)
    {
        $this->authorize('create', Role::class);
        // Create a new role
        $role = new Role;
        // Save the location data

        $role->company_id           = Company::getIdForCurrentUser($request->input('company_id'));
        $role->access_level         = request('access_level');
        $role->name                 = request('name');
        $role->user_id              = Auth::id();
        $role = $request->handleImages($role);


        if ($role->save()) {
            return redirect()->route('roles.index')->with('success', trans('admin/roles/message.create.success'));
        }
        return redirect()->back()->withInput()->withErrors($role->getErrors());
    }

    /**
     * role update.
     *
     * @param  int $roleId
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($roleId = null)
    {
        $this->authorize('update', Role::class);
        // Check if the role exists
        if (is_null($item = Role::find($roleId))) {
            // Redirect to the Role  page
            return redirect()->route('roles.index')->with('error', trans('admin/roles/message.does_not_exist'));
        }

        // Show the page
        return view('roles/edit', compact('item'));
    }

    /**
     * Role update form processing page.
     *
     * @param  int $roleId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update($roleId, ImageUploadRequest $request)
    {
        $this->authorize('update', Role::class);
        // Check if the role exists
        if (is_null($role = Role::find($roleId))) {
            // Redirect to the Role  page
            return redirect()->route('roles.index')->with('error', trans('admin/roles/message.does_not_exist'));
        }
        // Save the  data
        $role->company_id           = Company::getIdForCurrentUser($request->input('company_id'));
        $role->name                 = request('name');
        $role->project_id           = $request->input('project_id');

        if ($role->save()) {
            return redirect()->route('roles.index')->with('success', trans('admin/roles/message.update.success'));
        }

        return redirect()->back()->withInput()->withErrors($role->getErrors());

    }

    /**
     * Delete the given role.
     *
     * @param  int $roleId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($roleId)
    {
        $this->authorize('delete', Role::class);
        if (is_null($role = Role::find($roleId))) {
            return redirect()->route('roles.index')->with('error', trans('admin/roles/message.not_found'));
        }

        $role->delete();
        return redirect()->route('roles.index')->with('success',
            trans('admin/roles/message.delete.success')
        );


    }


    /**
     *  Get the asset information to present to the role view page
     *
     * @param null $roleId
     * @return \Illuminate\Contracts\View\View
     * @internal param int $assetId
     */
    public function show($roleId = null)
    {
        $role = Role::find($roleId);

        if (isset($role->id)) {
                return view('roles/view', compact('role'));
        }

        return redirect()->route('roles.index')->with('error', trans('admin/role/message.does_not_exist'));
    }

}
