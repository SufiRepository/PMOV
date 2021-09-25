<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ImplementationFile;
// use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


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
    public function index()
    {
         // Grab all the Team
         $this->authorize('view', ImplementationFile::class);
         // Show the page
         return view('implementationfiles.index');
    }


    /**
     * Assignwork create.
     *
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        return view('implementationfiles.edit')->with('item', new ImplementationFile);
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
    
            $fileModel = new ImplementationFile;
    
            if($request->file()) {

                $fileName = $request->input('filename').'.'.$request->file->getClientOriginalExtension();
                $filePath = $request->file('file')->storeAs('implementation_files', $fileName, 'public');
    
                $fileModel->filename = $request->input('filename').'.'.$request->file->getClientOriginalExtension();
                $fileModel->implementationplan_id = $request->input('implementationplans_id');
                $fileModel->notes = $request->input('notes');
                $fileModel->name = $request->input('filename');
                $fileModel->file_path = '/storage/' . $filePath;
                $fileModel->save();
    
                // return redirect()->route('implementationuploads.index')
                // ->with('success','File has been uploaded.')
                // ->with('file', $fileName);

                $implementationplanId = $fileModel->implementationplan_id;

                return redirect()->route('impreroute', ['implementationplanid' => $implementationplanId])->with('success','File has been uploaded.')
                ->with('file', $fileName);
            }
    }

    /**
     * assignwork update.
     *
     * @param  int $assignworkId
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($implementationfileId = null)
    {
        $this->authorize('update', ImplementationFile::class);
        // Check if the team exists
        if (is_null($item = ImplementationFile::find($implementationfileId))) {
            return redirect()->route('projectuploads.index')->with('error', trans('admin/teams/message.does_not_exist'));
        }


        return view('implementationfiles.edit', compact('item'));
    }

  
    /**
     * assignwork update form processing page.
     *
     * @param  int $assignrworkId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update($implementationfileId = null, ImageUploadRequest $request)
    {
        $this->authorize('update', ImplementationFile::class);
        // Check if the file exists
        if (is_null($implementationfile = ImplementationFile::find($implementationfileId))) {
            return redirect()->route('projects.index')->with('error', trans('admin/teams/message.does_not_exist'));
        }

        // Update the team data
        // $file->user_id      = $request->input('user_id');
  
        if ($implementationfile->save()) {
            return redirect()->route("projects.index")->with('success', trans('admin/teams/message.update.success'));
        }
        return redirect()->back()->withInput()->withInput()->withErrors($implementationfile->getErrors());
    }

    /**
     * Delete the given assignwork.
     *
     * @param  int $assignworkId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($implementationfileId)
    {
        $this->authorize('delete', ImplementationFile::class);
        if (is_null($implementationfile = ImplementationFile::find($implementationfileId))) {
            return redirect()->route('projects.index')->with('error', trans('admin/clients/message.not_found'));
        }

        $implementationfile->delete();
        return redirect()->route('projects.index')->with('success',
            trans('admin/clients/message.delete.success')
        );

        $implementationplanId = $implementationfile->implementationplan_id;

        return redirect()->route('impreroute', ['implementationplanid' => $implementationplanId])->with('success','File has been Deleted.')
        ->with('file', $fileName);
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
        $implementationfile = ImplementationFile::find($id);

        if (isset($implementationfile->id)) {
            return view('implementationfile.view', compact('file'));
        }

        return redirect()->route('projectuploads.index')->with('error', trans('admin/teams/message.does_not_exist'));
    }
    
}