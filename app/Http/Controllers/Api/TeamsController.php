<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;

use App\Http\Controllers\Controller;
use App\Http\Transformers\teamsTransformer;
use App\Http\Transformers\SelectlistTransformer;
use App\Models\Team;

use App\Models\Company;
use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;
use Auth;
use DB;

use Illuminate\Http\Request;

class TeamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', Team::class);
        $allowed_columns = [
            'id',
            'created_at',
            'updated_at',
            'user_id',
            'project_id',
            'role_id'
        ];

        
        $teams = Team::select('teams.*');

        if ($request->filled('search')) {
            $teams = $teams->TextSearch($request->input('search'));
        }

        if ($request->filled('project_id')) {
            $teams->where('project_id','=',$request->input('project_id'));
        }

        if ($request->filled('user_id')) {
            $teams->where('user_id','=',$request->input('user_id'));
        }


        // Set the offset to the API call's offset, unless the offset is higher than the actual count of items in which
        // case we override with the actual count, so we should return 0 items.
        $offset = (($teams) && ($request->get('offset') > $teams->count())) ? $teams->count() : $request->get('offset', 0);

        // Check to make sure the limit is not higher than the max allowed
        ((config('app.max_results') >= $request->input('limit')) && ($request->filled('limit'))) ? $limit = $request->input('limit') : $limit = config('app.max_results');


        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';


        $total = $teams->count();
        $teams = $teams->skip($offset)->take($limit)->get();
        return (new TeamsTransformer)->transformTeams($teams, $total);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Team::class);
        $team = new Team;
        $team->fill($request->all());
        $team->team_project               = $request->get('user_id', Team::autoincrement_team());
        $team->role                       = $request->get('role');
        $team->project_id                 =$request->get('project_id',null);


        if ($team->saveTeam()) {
            return response()->json(Helper::formatStandardApiResponse('success', $team, trans('admin/teams/message.create.success')));
        }
        return response()->json(Helper::formatStandardApiResponse('error', null, $team->getErrors()));

    }

    /**
     * Display the specified resource.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$this->authorize('view', Team::class);
        $Team = Team::findOrFail($id);
        return (new teamsTransformer)->transformTeam($Team);
    }


    /**
     * Update the specified resource in storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //$this->authorize('update', Team::class);
        $Team = Team::findOrFail($id);
        $Team->fill($request->all());

        if ($Team->saveTeam()) {
            return response()->json(Helper::formatStandardApiResponse('success', $Team, trans('admin/teams/message.update.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $Team->getErrors()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //$this->authorize('delete', Team::class);
        $Team = Team::findOrFail($id);
        $this->authorize($Team);

        if ($Team->hasUsers() > 0) {
            return response()->json(Helper::formatStandardApiResponse('error', null,  trans('admin/teams/message.assoc_users', array('count'=> $Team->hasUsers()))));
        }

        $Team->delete();
        return response()->json(Helper::formatStandardApiResponse('success', null,  trans('admin/teams/message.delete.success')));

    }

}
