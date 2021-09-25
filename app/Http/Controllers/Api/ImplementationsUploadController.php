<?php

namespace App\Http\Controllers\Api;

use App\Http\Transformers\ImplementationFilesTransformer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ImplementationFile;
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
class ImplementationsUploadController extends Controller
{
    /**
     * Show a list of all Assignworks
     *
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('view', ImplementationFile::class);
        $allowed_columns = ['id','name','file_path','notes','implementationplan_id'];

        
        $implementationfiles = ImplementationFile::select('implementations_files.*');

        if ($request->filled('search')) {
            $implementationfiles = $implementationfiles->TextSearch($request->input('search'));
        }

        if ($request->filled('implementationplan_id')) {
            $implementationfiles->where('implementationplan_id','=',$request->input('implementationplan_id'));
        }


        // Set the offset to the API call's offset, unless the offset is higher than the actual count of items in which
        // case we override with the actual count, so we should return 0 items.
        $offset = (($implementationfiles) && ($request->get('offset') > $implementationfiles->count())) ? $implementationfiles->count() : $request->get('offset', 0);

        // Check to make sure the limit is not higher than the max allowed
        ((config('app.max_results') >= $request->input('limit')) && ($request->filled('limit'))) ? $limit = $request->input('limit') : $limit = config('app.max_results');


        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';


        $total = $implementationfiles->count();
        $implementationfiles = $implementationfiles->skip($offset)->take($limit)->get();
        return (new ImplementationFilesTransformer)->transformImplementationFiles($implementationfiles, $total);
    }


    /**
     * Assignwork create.
     *
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        return view('implementationfiles.edit')->with('item', new File);
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
        $this->authorize('create', ImplementationFile::class);
        $implementationfile = new ImplementationFile;
        $implementationfile->fill($request->all());

        if ($implementationfile->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $implementationfile, trans('admin/teams/message.create.success')));
        }
        return response()->json(Helper::formatStandardApiResponse('error', null, $implementationfile->getErrors()));
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
        $ImplementationFile = ImplementationFile::findOrFail($id);
        $ImplementationFile->fill($request->all());

        if ($ImplementationFile->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $ImplementationFile, trans('admin/teams/message.update.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $ImplementationFile->getErrors()));
    }

    /**
     * Delete the given assignwork.
     *
     * @param  int $assignworkId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($implementationId)
    {
        //$this->authorize('delete', Team::class);
        $implementationFile = ImplementationFile::findOrFail($id);
        $this->authorize($implementationFile);

        if ($implementationFile->hasUsers() > 0) {
            return response()->json(Helper::formatStandardApiResponse('error', null,  trans('admin/teams/message.assoc_users', array('count'=> $implementationFile->hasUsers()))));
        }

        $implementationFile->delete();
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
        $implementationFile = ImplementationFile::findOrFail($id);
        return (new ImplementationFilesTransformer)->transformImplementationFiles($implementationFile);
    }
}