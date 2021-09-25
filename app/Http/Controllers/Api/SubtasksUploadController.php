<?php

namespace App\Http\Controllers\Api;

use App\Http\Transformers\SubtaskFileTransformer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubtaskFile;
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
class SubtasksUploadController extends Controller
{
    /**
     * Show a list of all Assignworks
     *
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('view', SubtaskFile::class);
        $allowed_columns = ['id','name','file_path','notes','subtask_id'];

        
        $subtaskfiles = SubtaskFile::select('subtasks_files.*');

        if ($request->filled('search')) {
            $subtaskfiles = $subtaskfiles->TextSearch($request->input('search'));
        }

        if ($request->filled('subtask_id')) {
            $subtaskfiles->where('subtasks_files.subtask_id', '=', $request->input('subtask_id'));
        }


        // Set the offset to the API call's offset, unless the offset is higher than the actual count of items in which
        // case we override with the actual count, so we should return 0 items.
        $offset = (($subtaskfiles) && ($request->get('offset') > $subtaskfiles->count())) ? $subtaskfiles->count() : $request->get('offset', 0);

        // Check to make sure the limit is not higher than the max allowed
        ((config('app.max_results') >= $request->input('limit')) && ($request->filled('limit'))) ? $limit = $request->input('limit') : $limit = config('app.max_results');


        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';


        $total = $subtaskfiles->count();
        $subtaskfiles = $subtaskfiles->skip($offset)->take($limit)->get();
        return (new SubtaskFileTransformer)->transformSubtaskFiles($subtaskfiles, $total);
    }


    /**
     * Assignwork create.
     *
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        return view('subtaskfile.edit')->with('item', new SubtaskFile);
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
        $this->authorize('create',SubtaskFile::class);
        $subtaskfile = new SubtaskFile;
        $subtaskfile->fill($request->all());

        if ($subtaskfile->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $subtaskfile, trans('admin/teams/message.create.success')));
        }
        return response()->json(Helper::formatStandardApiResponse('error', null, $subtaskfile->getErrors()));
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
    public function update($subtaskId, ImageUploadRequest $request)
    {
        $SubtaskFile = SubtaskFile::findOrFail($id);
        $SubtaskFile->fill($request->all());

        if ($SubtaskFile->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $SubtaskFile, trans('admin/teams/message.update.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $SubtaskFile->getErrors()));
    }

    /**
     * Delete the given assignwork.
     *
     * @param  int $assignworkId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($subtaskId)
    {
        //$this->authorize('delete', Team::class);
        $SubtaskFile = SubtaskFile::findOrFail($id);
        $this->authorize($SubtaskFile);

        if ($SubtaskFile->hasUsers() > 0) {
            return response()->json(Helper::formatStandardApiResponse('error', null,  trans('admin/teams/message.assoc_users', array('count'=> $SubtaskFile->hasUsers()))));
        }

        $SubtaskFile->delete();
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
        $SubtaskFile = SubtaskFile::findOrFail($id);
        return (new SubtaskFilesTransformer)->transformSubtaskFile($SubtaskFile);
    }
}