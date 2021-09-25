<?php

namespace App\Http\Controllers\Api;

use App\Http\Transformers\TaskFilesTransformer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TaskFile;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;
use DB;


/**
 * This controller handles all actions related to assignwork for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 */
class TasksUploadController extends Controller
{
    /**
     * Show a list of all Assignworks
     *
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('view', TaskFile::class);
        $allowed_columns = ['id','name','file_path','notes','task_id'];

        
        $taskfiles = TaskFile::select('tasks_files.*');

        if ($request->filled('search')) {
            $taskfiles = $taskfiles->TextSearch($request->input('search'));
        }

        if ($request->filled('task_id')) {
            $taskfiles->where('task_id','=',$request->input('task_id'));
        }


        // Set the offset to the API call's offset, unless the offset is higher than the actual count of items in which
        // case we override with the actual count, so we should return 0 items.
        $offset = (($taskfiles) && ($request->get('offset') > $taskfiles->count())) ? $taskfiles->count() : $request->get('offset', 0);

        // Check to make sure the limit is not higher than the max allowed
        ((config('app.max_results') >= $request->input('limit')) && ($request->filled('limit'))) ? $limit = $request->input('limit') : $limit = config('app.max_results');


        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';


        $total = $taskfiles->count();
        $taskfiles = $taskfiles->skip($offset)->take($limit)->get();
        return (new TaskFilesTransformer)->transformTaskFiles($taskfiles, $total);
    }


    /**
     * Assignwork create.
     *
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        return view('tasksfile.edit')->with('item', new TaskFile);
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
        $this->authorize('create', TaskFile::class);
        $taskfile = new TaskFile;
        $taskfile->fill($request->all());

        if ($taskfile->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $taskfile, trans('admin/teams/message.create.success')));
        }
        return response()->json(Helper::formatStandardApiResponse('error', null, $taskfile->getErrors()));
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
        $TaskFile = TaskFile::findOrFail($id);
        $TaskFile->fill($request->all());

        if ($TaskFile->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $TaskFile, trans('admin/teams/message.update.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $TaskFile->getErrors()));
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
        //$this->authorize('delete', Team::class);
        $TaskFile = TaskFile::findOrFail($id);
        $this->authorize($TaskFile);

        if ($TaskFile->hasUsers() > 0) {
            return response()->json(Helper::formatStandardApiResponse('error', null,  trans('admin/teams/message.assoc_users', array('count'=> $TaskFile->hasUsers()))));
        }

        $TaskFile->delete();
        return response()->json(Helper::formatStandardApiResponse('success', null,  trans('admin/teams/message.delete.success')));
    }


    /**
     *  Get the asset information to present to the assignwork view page
     *
     * @param null $assignworkId
     * @return \Illuminate\Contracts\View\View
     * @internal param int $assetId
     */
    public function show($id)
    {
        $TaskFile = TaskFile::findOrFail($id);
        return (new TaskFilesTransformer)->transformTaskFile($TaskFile);
    }
}