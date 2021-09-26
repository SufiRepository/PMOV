<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubtaskFile;
use App\Models\File;
use App\Models\Subtask;
// use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


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
    public function index()
    {
         // Grab all the Team
         $this->authorize('view', SubtaskFile::class);
         // Show the page
         return view('subtaskfile.index');
    }


    /**
     * Assignwork create.
     *
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Request $request)
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
        $request->validate([
            'file' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048'
            ]);
    
            $projectfiles = new File;
            $fileModel = new SubtaskFile;
    
            if($request->file()) {
                $fileName = $request->input('filename').'.'.$request->file->getClientOriginalExtension();
                $filePath = $request->file('file')->storeAs('subtask_files', $fileName, 'public');
    
                $fileModel->filename = $request->input('filename').'.'.$request->file->getClientOriginalExtension();
                $fileModel->subtask_id = $request->input('subtasks_id');
                $fileModel->notes = $request->input('notes');
                $fileModel->name = $request->input('filename');
                $fileModel->file_path = '/storage/' . $filePath;
                $fileModel->save();

                $fileName = $request->input('filename').'.'.$request->file->getClientOriginalExtension();
                $projectfilespath = $request->file('file')->storeAs('project_files', $fileName, 'public');
    
                $projectfiles->filename = $request->input('filename').'.'.$request->file->getClientOriginalExtension();
                $projectfiles->subtask_id = $request->input('subtasks_id');
                $projectfiles->notes = $request->input('notes');
                $projectfiles->name = $request->input('filename');
                $projectfiles->file_path = '/storage/' . $projectfilespath;


                $subtask = Subtask::find($request->input('subtasks_id'));
                $projectfiles->file_location = $subtask->name;
                $projectfiles->project_id = $subtask->project_id;
                $projectfiles->save();
    
                // return redirect()->route('subtaskuploads.index')
                // ->with('success','File has been uploaded.')
                // ->with('file', $fileName);

                $subtaskId = $fileModel->subtask_id;
            return redirect()->route('subtasksreroute',['subtaskid'=>$subtaskId]) ->with('success','File has been uploaded.')->with('file', $fileName);
            }
    }

    /**
     * assignwork update.
     *
     * @param  int $assignworkId
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($subtaskfileId = null)
    {
        $this->authorize('update', SubtaskFile::class);
        // Check if the team exists
        if (is_null($item = SubtaskFile::find($subtaskfileId))) {
            return redirect()->route('implementationplans.view')->with('error', trans('admin/teams/message.does_not_exist'));
        }


        return view('subtaskfile.edit', compact('item'));
    }

  
    /**
     * assignwork update form processing page.
     *
     * @param  int $assignrworkId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update($subtaskfileId = null, ImageUploadRequest $request)
    {
        $this->authorize('update', SubtaskFile::class);
        // Check if the file exists
        if (is_null($subtaskfile = SubtaskFile::find($subtaskfileId))) {
            return redirect()->route('subtaskuploads.index')->with('error', trans('admin/teams/message.does_not_exist'));
        }

        // Update the team data
        // $file->user_id      = $request->input('user_id');
  
        if ($subtaskfile->save()) {
            return redirect()->route("projects.index")->with('success', trans('admin/teams/message.update.success'));
        }
        return redirect()->back()->withInput()->withInput()->withErrors($team->getErrors());
    }

    /**
     * Delete the given assignwork.
     *
     * @param  int $assignworkId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($subtaskfileId)
    {
        $this->authorize('delete', SubtaskFile::class);
        if (is_null($subtaskfile = SubtaskFile::find($subtaskfileId))) {
            return redirect()->route('projects.index')->with('error', trans('admin/clients/message.not_found'));
        }

        $team->delete();
        return redirect()->route('projects.index')->with('success',
            trans('admin/clients/message.delete.success')
        );


    }


    /**
     *  Get the asset information to present to the assignwork view page
     *
     * @param null $assignworkId
     * @return \Illuminate\Contracts\View\View
     * @internal param int $assetId
     */
    public function show($id = null)
    {
        $subtaskfile = SubtaskFile::find($id);

        if (isset($subtaskfile->id)) {
            return view('subtaskfile.view', compact('file'));
        }

        return redirect()->route('subtaskuploads.index')->with('error', trans('admin/teams/message.does_not_exist'));
    }
    
}