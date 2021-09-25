<?php

namespace App\Http\Controllers\Api;


use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Transformers\RolesTransformer;
use App\Http\Transformers\SelectlistTransformer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
//sufi@mindwave.my: added
use App\Models\Company;
use App\Models\User;
use App\Models\Project;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
// add by farez 28/5/2021
use App\Models\Location;
// add by farez 16/6//2021
use App\Models\Role;
use App\models\Client;
use App\models\Contactor;


class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @author farez@mindawave.my
     * @since [v4.0]
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', Role::class);
        $allowed_columns = [
            
            'id',
            'name',
        ];

        // old code

        // $proj_access = Auth::user()->company_id;
        // $projects = Company::scopeCompanyables(Project::select('projects.*'),"company_id","projects");

        // end old code

        // new code 21/5/21

         $user_id = Auth::id();
            // $user = 
            // $projects = Project::withCount('assets as assets_count','licenses as licenses_count','accessories as accessories_count','consumables as consumables_count','components as components_count','users as users_count')
            // ->where('user.id','=',Auth::id());
        
            $roles= Role::select('roles.*') -> where('user_id','=', $user_id);
        // end new code 
        

        if ($request->input('deleted')=='true') {
            $roles->onlyTrashed();
        }

    
            

        // Set the offset to the API call's offset, unless the offset is higher than the actual count of items in which
        // case we override with the actual count, so we should return 0 items.
        $offset = (($roles) && ($request->get('offset') > $roles->count())) ? $roles->count() : $request->get('offset', 0);

        // Check to make sure the limit is not higher than the max allowed
        ((config('app.max_results') >= $request->input('limit')) && ($request->filled('limit'))) ? $limit = $request->input('limit') : $limit = config('app.max_results');

        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';
        //sufi@mindwave .. disable $roles->orderBy($sort, $order);

        $total = $roles->count();
        $roles = $roles->skip($offset)->take($limit)->get();
        return (new RolesTransformer)->transformRoles($roles, $total);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @author farez@mindwave.my
     * @since [v4.0]
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Role::class);
        $role = new Role;
        $role->fill($request->all());

        if ($role->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $role, trans('admin/roles/message.create.success')));
        }
        return response()->json(Helper::formatStandardApiResponse('error', null, $role->getErrors()));
    }

    /**
     * Display the specified resource.
     *
     * @author farez@mindwave.my
     * @since [v4.0]
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', Role::class);
        // $task = Task::withCount('assets as assets_count')->withCount('licenses as licenses_count')->withCount('consumables as consumables_count')->withCount('accessories as accessories_count')->findOrFail($id);
        return (new RolesTransformer)->transformRole($role);
    }


    /**
     * Update the specified resource in storage.
     *
     * @author farez@mindwave.my
     * @since [v4.0]
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('update', Role::class);
        $role = Role::findOrFail($id);
        $role->fill($request->all());

        if ($role->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $role, trans('admin/roles/message.update.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $role->getErrors()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @author farez@mindwave.my
     * @since [v4.0]
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $this->authorize('delete', Role::class);
        $role = Role::findOrFail($id);
        $this->authorize('delete', $manufacturer);

        if ($role->isDeletable()) {
            $role->delete();
            return response()->json(Helper::formatStandardApiResponse('success', null,  trans('admin/roles/message.delete.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null,  trans('admin/roles/message.assoc_users')));
    }

    /**
     * Gets a paginated collection for the select2 menus
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0.16]
     * @see \App\Http\Transformers\SelectlistTransformer
     *
     */
    public function selectlist(Request $request)
    {

        $roles = Role::select([
            'id',
            'name',
            'image',
        ]);

        if ($request->filled('search')) {
            $roles = $roles->where('name', 'LIKE', '%'.$request->get('search').'%');
        }

        $roles = $roles->orderBy('name', 'ASC')->paginate(50);

        // Loop through and set some custom properties for the transformer to use.
        // This lets us have more flexibility in special cases like assets, where
        // they may not have a ->name value but we want to display something anyway
        foreach ($roles as $roles) {
            $roles->use_text = $roles->name;
            $roles->use_image = ($roles->image) ? Storage::disk('public')->url('roles/'.$role->image, $roles->image) : null;
        }

        return (new SelectlistTransformer)->transformSelectlist($roles);

    }
}
