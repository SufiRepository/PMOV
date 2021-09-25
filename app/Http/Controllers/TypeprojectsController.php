<?php
namespace App\Http\Controllers;

use App\Http\Requests\ImageUploadRequest;
use App\Models\Typeproject;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;

/**
 * This controller handles all actions related to typeprojects for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 */
class TypeprojectsController extends Controller
{
    /**
     * Show a list of all typeprojects
     *
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        // Grab all the typeprojects
        $this->authorize('view', Typeproject::class);

        // Show the page
        return view('typeprojects/index');
    }


    /**
     * typeproject create.
     *
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Typeproject::class);
        return view('typeprojects/edit')->with('item', new Typeproject);
    }


    /**
     * typeproject create form processing.
     *
     * @param ImageUploadRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(ImageUploadRequest $request)
    {
        $this->authorize('create', Typeproject::class);
        // Create a new typeproject
        $typeproject = new Typeproject;
        // Save the location data
        $typeproject->company_id           = Company::getIdForCurrentUser($request->input('company_id'));
        $typeproject->name                 = request('name');
        $typeproject->user_id              = Auth::id();
        $suppltypeprojectier               = $request->handleImages($typeproject);

        if ($typeproject->save()) {
            return redirect()->route('typeprojects.index')->with('success', trans('admin/typeprojects/message.create.success'));
        }
        return redirect()->back()->withInput()->withErrors($typeproject->getErrors());
    }

    /**
     * Typeproject update.
     *
     * @param  int $typeprojectId
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($typeprojectId = null)
    {
        $this->authorize('update', Typeproject::class);
        // Check if the typeproject exists
        if (is_null($item = Typeproject::find($typeprojectId))) {
            // Redirect to the typeproject  page
            return redirect()->route('typeprojects.index')->with('error', trans('admin/typeprojects/message.does_not_exist'));
        }

        // Show the page
        return view('typeprojects/edit', compact('item'));
    }


    /**
     * typeprojet update form processing page.
     *
     * @param  int $typeprojectId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update($typeprojectId, ImageUploadRequest $request)
    {
        $this->authorize('update', Typeproject::class);
        // Check if the typeproject exists
        if (is_null($typeproject = Typeproject::find($typeprojectId))) {
            // Redirect to the typeproject  page
            return redirect()->route('typeprojects.index')->with('error', trans('admin/typeprojects/message.does_not_exist'));
        }

        // Save the  data
        $typeproject ->company_id           = Company::getIdForCurrentUser($request->input('company_id'));
        $typeproject ->name                 = request('name');
        $typeproject                       = $request->handleImages($typeproject);

        if ($typeproject->save()) {
            return redirect()->route('typeprojects.index')->with('success', trans('admin/typeprojects/message.update.success'));
        }

        return redirect()->back()->withInput()->withErrors($typeproject->getErrors());

    }

    /**
     * Delete the given typeproject.
     *
     * @param  int $typeprojectId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($typeprojectId)
    {
        $this->authorize('delete', Typeproject::class);
        if (is_null($typeproject = Typeproject::with('asset_maintenances', 'assets', 'licenses')->withCount('asset_maintenances as asset_maintenances_count','assets as assets_count','licenses as licenses_count')->find($typeprojectId))) {
            return redirect()->route('typeprojects.index')->with('error', trans('admin/typeprojects/message.not_found'));
        }


        if ($typeproject->assets_count > 0) {
            return redirect()->route('typeprojects.index')->with('error', trans('admin/typeprojects/message.delete.assoc_assets', ['asset_count' => (int) $typeproject->assets_count]));
        }

        if ($typeproject->asset_maintenances_count > 0) {
            return redirect()->route('typeprojects.index')->with('error', trans('admin/typeprojects/message.delete.assoc_maintenances', ['asset_maintenances_count' => $typeproject->asset_maintenances_count]));
        }

        if ($typeproject->licenses_count > 0) {
            return redirect()->route('typeprojects.index')->with('error', trans('admin/typeprojects/message.delete.assoc_licenses', ['licenses_count' => (int) $typeproject->licenses_count]));
        }

        $typeproject->delete();
        return redirect()->route('typeprojects.index')->with('success',
            trans('admin/typeprojects/message.delete.success')
        );


    }


    /**
     *  Get the asset information to present to the typeproject view page
     *
     * @param null $typeprojectId
     * @return \Illuminate\Contracts\View\View
     * @internal param int $assetId
     */
    public function show($typeprojectId = null)
    {
        $typeproject = Typeproject::find($typeprojectId);

        if (isset($typeproject->id)) {
                return view('typeprojects/view', compact('typeproject'));
        }

        return redirect()->route('typeprojects.index')->with('error', trans('admin/typeprojects/message.does_not_exist'));
    }

}
