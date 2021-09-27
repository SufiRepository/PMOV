<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
// use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


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
    public function index()
    {
         // Grab all the Team
         $this->authorize('view', File::class);
         // Show the page
         return view('projectfile.index');
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
        $request->validate([
            'file' => 'required|mimes:csv,txt,xlx,xls,pdf|max:5120'
            ]);
    
            $fileModel = new File;
    
            if($request->file()) {
                $fileName = $request->input('filename').'.'.$request->file->getClientOriginalExtension();
                $filePath = $request->file('file')->storeAs('project_files', $fileName, 'public');

                $fileModel->filename = $request->input('filename').'.'.$request->file->getClientOriginalExtension();
                $fileModel->project_id = $request->input('project_id');
                $fileModel->notes = $request->input('notes');
                $fileModel->name = $request->input('filename');
                $fileModel->file_path = '/storage/' . $filePath;
                $fileModel->save();
    
                // return redirect()->route('projectuploads.index')
                // ->with('success','File has been uploaded.')
                // ->with('file', $fileName);

                $projectId = $fileModel->project_id;

                return redirect()->route('projectsreroute', ['projectid' => $projectId]) ->with('success','File has been uploaded.')
                ->with('file', $fileName);

                // $implementationplanId = $fileModel->implementationplan_id;

                // return redirect()->route('impreroute', ['implementationplanid' => $implementationplanId])   ->with('success','File has been uploaded.')
                // ->with('file', $fileName);


            }
    }

    /**
     * assignwork update.
     *
     * @param  int $fileId
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($fileId = null)
    {
        $this->authorize('update', File::class);
        // Check if the team exists
        if (is_null($item = File::find($fileId))) {
            return redirect()->route('projectuploads.index')->with('error', trans('admin/teams/message.does_not_exist'));
        }


        return view('projectfile.edit', compact('item'));
    }

  
    /**
     * assignwork update form processing page.
     *
     * @param  int $fileId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update($fileId = null, ImageUploadRequest $request)
    {
        $this->authorize('update', File::class);
        // Check if the file exists
        if (is_null($file = File::find($fileId))) {
            return redirect()->route('projects.index')->with('error', trans('admin/teams/message.does_not_exist'));
        }

        // Update the team data
        // $file->user_id      = $request->input('user_id');
  
        if ($file->save()) {
            return redirect()->route("projects.index")->with('success', trans('admin/teams/message.update.success'));
        }
        return redirect()->back()->withInput()->withInput()->withErrors($team->getErrors());
    }

    /**
     * Delete the given assignwork.
     *
     * @param  int $fileId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($fileId)
    {
       $this->authorize('delete', File::class);
        if (is_null($file = File::find($fileId))) {
            return redirect()->route('projects.index')->with('error', trans('admin/clients/message.not_found'));
        }

        $file->delete();
        return redirect()->route('projects.index')->with('success',
            trans('admin/clients/message.delete.success')
        );

    }


    /**
     *  Get the asset information to present to the assignwork view page
     *
     * @param null $fileId
     * @return \Illuminate\Contracts\View\View
     * @internal param int $assetId
     */
    public function show($id = null)
    {
        $file = File::find($id);

        if (isset($file->id)) {
            return view('projectfile.view', compact('file'));
        }

        return redirect()->route('projectuploads.index')->with('error', trans('admin/teams/message.does_not_exist'));
    }
    
}