<?php
namespace App\Http\Controllers;

use App\Http\Requests\ImageUploadRequest;
use App\Models\Work;
use App\Models\Company;
use App\Models\user;
use App\Models\Contractor;
use App\Models\Client;

use Illuminate\Support\Facades\Auth;

/**
 * This controller handles all actions related to Works for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 */
class WorksController extends Controller
{
    /**
     * Show a list of all Works
     *
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        // Grab all the Works
        $this->authorize('view', Work::class);

        $counts['project'] = \App\Models\Project::count();
        $counts['contractor'] = \App\Models\Contractor::count();
        $counts['client'] = \App\Models\Client::count(); 
        $counts['work'] = \App\Models\Work::count(); 
        // Show the page
        return view('works/index')->with('counts', $counts);
    }


    /**
     * work create.
     *
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Work::class);
        return view('works/edit')->with('item', new Work);
    }


    /**
     * Work create form processing.
     *
     * @param ImageUploadRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(ImageUploadRequest $request)
    {
        $this->authorize('create', Work::class);
        // Create a new work
        $project = new Project();
        Log::info('view');
        // Save the  data
        $work->company_id            = Company::getIdForCurrentUser($request->input('company_id'));
        $work->name                  = $request->input('name');
        $work->costing               = $request->input('costing');
        $work->details               = $request->input('details');
        $work->due_date              = $request->input('due_date');
        $work->start_date            = $request->input('start_date');
        $work->location_id           = $request->input('location_id');
        $project->client_id             = $request->input('client_id');
        $work->contractor_id         =$request->input('contractor_id');
        $work->user_id               = Auth::id();


        if ($work->save()) {
            return redirect()->route('works.index')->with('success', trans('admin/works/message.create.success'));
        }
        return redirect()->back()->withInput()->withErrors($work->getErrors());
    }

    /**
     * work update.
     *
     * @param  int $workId
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($workId = null)
    {
        $this->authorize('update', Work::class);
        // Check if the work exists
        if (is_null($item = Work::find($workId))) {
            // Redirect to the work  page
            return redirect()->route('works.index')->with('error', trans('admin/works/message.does_not_exist'));
        }

        // Show the page
        return view('works/edit', compact('item'));
    }


    /**
     * work update form processing page.
     *
     * @param  int $workId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update($workId, ImageUploadRequest $request)
    {
        $this->authorize('update', Work::class);
        // Check if the work exists
        if (is_null($work = Work::find($workId))) {
            // Redirect to the work  page
            return redirect()->route('works.index')->with('error', trans('admin/works/message.does_not_exist'));
        }

        // Save the  data
        $work->company_id            = Company::getIdForCurrentUser($request->input('company_id'));
        $work->name                  = $request->input('name');
        $work->costing               = $request->input('costing');
        $work->details               = $request->input('details');
        $work->due_date              = $request->input('due_date');
        $work->start_date            = $request->input('start_date');
        $work->location_id           = $request->input('location_id');
        $work->client_id             = $request->input('client_id');
        $work->contractor_id         =$request->input('contractor_id');
      

        if ($work->save()) {
            return redirect()->route('works.index')->with('success', trans('admin/works/message.update.success'));
        }

        return redirect()->back()->withInput()->withErrors($client->getErrors());

    }

    /**
     * Delete the given work.
     *
     * @param  int $workId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($workId)
    {
        $this->authorize('delete', Work::class);
        if (is_null($work = Work::find($workId))) {
            return redirect()->route('works.index')->with('error', trans('admin/works/message.not_found'));
        }


        // if ($work->assets_count > 0) {
        //     return redirect()->route('works.index')->with('error', trans('admin/works/message.delete.assoc_assets', ['asset_count' => (int) $work->assets_count]));
        // }

        // if ($work->asset_maintenances_count > 0) {
        //     return redirect()->route('works.index')->with('error', trans('admin/works/message.delete.assoc_maintenances', ['asset_maintenances_count' => $work->asset_maintenances_count]));
        // }

        // if ($work->licenses_count > 0) {
        //     return redirect()->route('works.index')->with('error', trans('admin/works/message.delete.assoc_licenses', ['licenses_count' => (int) $work->licenses_count]));
        // }

        $work->delete();
        return redirect()->route('works.index')->with('success',
            trans('admin/works/message.delete.success')
        );


    }


    /**
     *  Get the asset information to present to the work view page
     *
     * @param null $workId
     * @return \Illuminate\Contracts\View\View
     * @internal param int $assetId
     */
    public function show($workId = null)
    {
        $work = Work::find($workId);

        if (isset($work->id)) {
                return view('works/view', compact('work'));
        }

        return redirect()->route('works.index')->with('error', trans('admin/works/message.does_not_exist'));
    }

}
