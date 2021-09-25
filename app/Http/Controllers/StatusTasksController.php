<?php
namespace App\Http\Controllers;

use App\Http\Requests\ImageUploadRequest;
use App\Models\StatusTask;

use App\Models\Company;
use Illuminate\Support\Facades\Auth;

/**
 * This controller handles all actions related to statustasks for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 */
class StatusTasksController extends Controller
{
    /**
     * Show a list of all statustasks
     *
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        // Grab all the statustasks
        $this->authorize('view', StatusTask::class);

        // Show the page
        return view('statustasks/index');
    }


    /**
     * StatusTask create.
     *
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', StatusTask::class);

        return view('statustasks/edit')
        ->with('item', new StatusTask);
    }


    /**
     * StatusTask create form processing.
     *
     * @param ImageUploadRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(ImageUploadRequest $request)
    {
        $this->authorize('create', StatusTask::class);
        // Create a new statustask
        $statustask = new StatusTask;
        // Save the location data
        $statustask->company_id       = Company::getIdForCurrentUser($request->input('company_id'));
        $statustask->name                 = request('name');
    
        $statustask->user_id              = Auth::id();


        if ($statustask->save()) {
            return redirect()->route('statustasks.index')->with('success', trans('admin/statustask/message.create.success'));
        }
        return redirect()->back()->withInput()->withErrors($statustask->getErrors());
    }

    /**
     * statustask update.
     *
     * @param  int $statustaskId
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($statustaskId = null)
    {
        $this->authorize('update', StatusTask::class);
        // Check if the statustask exists
        if (is_null($item = StatusTask::find($statustaskId))) {
            // Redirect to the statustask  page
            return redirect()->route('statustasks.index')->with('error', trans('admin/statustask/message.does_not_exist'));
        }

        // Show the page
        return view('statustasks/edit', compact('item'));
    }


    /**
     * statustask update form processing page.
     *
     * @param  int $statustaskId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update($statustaskId, ImageUploadRequest $request)
    {
        $this->authorize('update', StatusTask::class);
        // Check if the statustask exists
        if (is_null($statustask = StatusTask::find($statustaskId))) {
            // Redirect to the statustask  page
            return redirect()->route('statustasks.index')->with('error', trans('admin/statustasks/message.does_not_exist'));
        }

        // Save the  data
        $statustask->company_id           = Company::getIdForCurrentUser($request->input('company_id'));
        $statustask->name                 = request('name');
     
        if ($statustask->save()) {
            return redirect()->route('statustasks.index')->with('success', trans('admin/statustasks/message.update.success'));
        }

        return redirect()->back()->withInput()->withErrors($statustask->getErrors());

    }

    /**
     * Delete the given statustask.
     *
     * @param  int $statustaskId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($statustaskId)
    {
        $this->authorize('delete', StatusTask::class);
        if (is_null($statustask = StatusTask::with('asset_maintenances', 'assets', 'licenses')->withCount('asset_maintenances as asset_maintenances_count','assets as assets_count','licenses as licenses_count')->find($statustask))) {
            return redirect()->route('statustasks.index')->with('error', trans('admin/statustasks/message.not_found'));
        }


        if ($statustask->assets_count > 0) {
            return redirect()->route('statustasks.index')->with('error', trans('admin/statustasks/message.delete.assoc_assets', ['asset_count' => (int) $statustask->assets_count]));
        }

        if ($statustask->asset_maintenances_count > 0) {
            return redirect()->route('statustasks.index')->with('error', trans('admin/statustasks/message.delete.assoc_maintenances', ['asset_maintenances_count' => $statustask->asset_maintenances_count]));
        }

        if ($statustask->licenses_count > 0) {
            return redirect()->route('statustasks.index')->with('error', trans('admin/statustasks/message.delete.assoc_licenses', ['licenses_count' => (int) $statustask->licenses_count]));
        }

        $statustask->delete();
        return redirect()->route('statustasks.index')->with('success',
            trans('admin/statustasks/message.delete.success')
        );


    }


    /**
     *  Get the asset information to present to the StatusTask view page
     *
     * @param null $statustaskId
     * @return \Illuminate\Contracts\View\View
     * @internal param int $assetId
     */
    public function show($statustaskId = null)
    {
        $statustask = StatusTask::find($statustaskId);

        if (isset($statustask->id)) {
                return view('statustasks/view', compact('statustask'));
        }

        return redirect()->route('statustasks.index')->with('error', trans('admin/statustasks/message.does_not_exist'));
    }

}
