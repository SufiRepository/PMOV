<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\File;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class FileUploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = null)
    {
        $file = File::find($id);
        log::info($file);
        
        if (isset($file->id)) {
            return view('uploads.file-upload', compact('file'));
        }

        return redirect()->route('subtasks.index')->with('error', trans('admin/subtasks/message.does_not_exist'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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

    public function project_files_upload()
    {
        $project_files = DB::table('files')->get();
        log::info($project_files);
    }
}
