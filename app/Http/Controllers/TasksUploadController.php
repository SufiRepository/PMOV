<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaskFile;
use App\Models\File;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


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
    public function index()
    {
         // Grab all the Team
         $this->authorize('view', TaskFile::class);
         // Show the page
         return view('tasksfile.index');
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
        $request->validate([
            'file' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048'
            ]);
            
            $projectfiles = new File;
            $fileModel = new TaskFile;
    
            if($request->file()) {
                $fileName = $request->input('filename').'.'.$request->file->getClientOriginalExtension();
                $filePath = $request->file('file')->storeAs('task_files', $fileName, 'public');
    
                $fileModel->filename = $request->input('filename').'.'.$request->file->getClientOriginalExtension();
                $fileModel->task_id = $request->input('task_id');
                $fileModel->notes = $request->input('notes');
                $fileModel->name = $request->input('filename');
                $fileModel->file_path = '/storage/' . $filePath;
                $fileModel->save();

                $fileName = $request->input('filename').'.'.$request->file->getClientOriginalExtension();
                $projectfilespath = $request->file('file')->storeAs('project_files', $fileName, 'public');
    
                $projectfiles->filename = $request->input('filename').'.'.$request->file->getClientOriginalExtension();
                $projectfiles->task_id = $request->input('task_id');
                $projectfiles->notes = $request->input('notes');
                $projectfiles->name = $request->input('filename');
                $projectfiles->file_path = '/storage/' . $projectfilespath;


                $task = Task::find($request->input('task_id'));
                $projectfiles->file_location = $task->name;
                $projectfiles->project_id = $task->project_id;
                $projectfiles->save();

                $taskId = $fileModel->task_id;
                return redirect()->route('tasksreroute',['taskid'=>$taskId])->with('success', trans('admin/files/message.create.success'));
            }
    }

    /**
     * assignwork update.
     *
     * @param  int $assignworkId
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($taskfileId = null)
    {
        $this->authorize('update', TaskFile::class);
        // Check if the team exists
        if (is_null($item = TaskFile::find($taskfileId))) {
            return redirect()->route('implementationplans.view')->with('error', trans('admin/teams/message.does_not_exist'));
        }


        return view('tasksfile.edit', compact('item'));
    }

  
    /**
     * assignwork update form processing page.
     *
     * @param  int $assignrworkId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update($taskfileId = null, ImageUploadRequest $request)
    {
        $this->authorize('update', TaskFile::class);
        // Check if the file exists
        if (is_null($taskfile = TaskFile::find($taskfileId))) {
            return redirect()->route('taskuploads.index')->with('error', trans('admin/teams/message.does_not_exist'));
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
     * @param  int $assignworkId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($taskfileId)
    {
        $this->authorize('delete', TaskFile::class);
        if (is_null($taskfile = TaskFile::find($taskfileId))) {
            return redirect()->route('projects.index')->with('error', trans('admin/clients/message.not_found'));
        }

        $taskfile->delete();
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
        $taskfile = TaskFile::find($id);

        if (isset($taskfile->id)) {
            return view('tasksfile.view', compact('file'));
        }

        return redirect()->route('taskuploads.index')->with('error', trans('admin/teams/message.does_not_exist'));
    }
    
}