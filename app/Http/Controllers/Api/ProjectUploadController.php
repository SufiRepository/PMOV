<?php

namespace App\Http\Controllers\Api;

use App\Http\Transformers\FilesTransformer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\File;
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
class ProjectUploadController extends Controller
{
    /**
     * Show a list of all Assignworks
     *
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('view', File::class);
        $allowed_columns = ['id','name','file_path','notes','project_id'];

        
        $files = File::select('files.*');

        if ($request->filled('search')) {
            $files = $files->TextSearch($request->input('search'));
        }

        if ($request->filled('project_id')) {
            $files->where('project_id','=',$request->input('project_id'));
        }


        // Set the offset to the API call's offset, unless the offset is higher than the actual count of items in which
        // case we override with the actual count, so we should return 0 items.
        $offset = (($files) && ($request->get('offset') > $files->count())) ? $files->count() : $request->get('offset', 0);

        // Check to make sure the limit is not higher than the max allowed
        ((config('app.max_results') >= $request->input('limit')) && ($request->filled('limit'))) ? $limit = $request->input('limit') : $limit = config('app.max_results');


        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';


        $total = $files->count();
        $files = $files->skip($offset)->take($limit)->get();
        return (new FilesTransformer)->transformFiles($files, $total);
    }


    /**
     * Assignwork create.
     *
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        return view('projectfile.edit')->with('item', new File);
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
        $this->authorize('create', File::class);
        $file = new File;
        $file->fill($request->all());

        if ($file->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $file, trans('admin/teams/message.create.success')));
        }
        return response()->json(Helper::formatStandardApiResponse('error', null, $file->getErrors()));
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
        $File = File::findOrFail($id);
        $File->fill($request->all());

        if ($File->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $File, trans('admin/teams/message.update.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $File->getErrors()));
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
        $File = File::findOrFail($id);
        $this->authorize($File);

        if ($File->hasUsers() > 0) {
            return response()->json(Helper::formatStandardApiResponse('error', null,  trans('admin/teams/message.assoc_users', array('count'=> $File->hasUsers()))));
        }

        $File->delete();
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
        $File = File::findOrFail($id);
        return (new FilesTransformer)->transformFile($File);
    }
}