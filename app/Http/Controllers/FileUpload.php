<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileUpload extends Controller
{
  public function createForm(Request $request){

    return view('uploads.file-upload');
  }

  public function createFormProject(Request $request){

    return view('uploads.project-upload');
  }

  public function createFormSubtask(Request $request){

    return view('uploads.subtask-upload');
  }

  public function fileUpload(Request $req){
        $req->validate([
        'file' => 'required|mimes:csv,txt,xlx,xls,pdf|max:5120'
        ]);

        $fileModel = new File;

        if($req->file()) {
            $fileName = time().'_'.$req->file->getClientOriginalName();
            $filePath = $req->file('file')->storeAs('uploads', $fileName, 'public');

            $fileModel->task_id = $req->input('task_id');
            $fileModel->project_id = $req->input('project_id');
            $fileModel->subtask_id = $req->input('subtask_id');
            $fileModel->name = time().'_'.$req->file->getClientOriginalName();
            $fileModel->file_path = '/storage/' . $filePath;
            $fileModel->save();

            return back()
            ->with('success','File has been uploaded.')
            ->with('file', $fileName);
        }
   }

   /**
    * Returns a view that invokes the ajax tables which actually contains
    * the content for the subtasks detail page.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param int $id
    * @since [v1.0]
    * @return \Illuminate\Contracts\View\View
     */
    public function show($id = null)
    {
        $file = File::find($id);
        var_dump($file);

        if (isset($file->id)) {
            return view('uploads.file-upload', compact('file'));
        }

        return redirect()->route('subtasks.index')->with('error', trans('admin/subtasks/message.does_not_exist'));
    }


     /**
     * Validates and deletes selected subtask.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param int $fileId
     * @since [v1.0]
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

}