<?php
namespace App\Http\Controllers;

use App\Http\Requests\ImageUploadRequest;
use App\Models\Contractor;
use App\Models\Client;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;

/**
 * This controller handles all actions related to Contractor for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 */
class ContractorsController extends Controller
{
    /**
     * Show a list of all contractors
     *
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        // Grab all the contractors
        // $this->authorize('view', Contractor::class);

        $clientcount = new Client;
        $contractorcount = new Contractor;

        $counts['client']   =  $clientcount     ->count_by_company();
        $counts['contractor']   =  $contractorcount     ->count_by_company();
        
        $counts['project'] = \App\Models\Project::count();
        $counts['supplier'] = \App\Models\Supplier::count();

        // $counts['contractor'] = \App\Models\Contractor::count();
        // $counts['client'] = \App\Models\Client::count(); 
        // Show the page
        return view('contractors/index')->with('counts', $counts);
    }


    /**
     * contractor create.
     *
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Contractor::class);
        return view('contractors/edit')->with('item', new Contractor);
    }


    /**
     * Contractor create form processing.
     *
     * @param ImageUploadRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(ImageUploadRequest $request)
    {
        // $this->authorize('create', Contractor::class);
        // Create a new Contractor
        $contractor = new Contractor;
        // Save the location data

        $contractor->company_id           = Company::getIdForCurrentUser($request->input('company_id'));
        $contractor->name                 = request('name');
        $contractor->address              = request('address');
        $contractor->address2             = request('address2');
        $contractor->city                 = request('city');
        $contractor->state                = request('state');
        $contractor->country              = request('country');
        $contractor->zip                  = request('zip');
        $contractor->contact              = request('contact');
        $contractor->phone                = request('phone');
        $contractor->fax                  = request('fax');
        $contractor->email                = request('email');
        $contractor->notes                = request('notes');
        $contractor->url                  = $contractor->addhttp(request('url'));
        $contractor->user_id              = Auth::id();
        $contractor = $request->handleImages($contractor);


        if ($contractor->save()) {
            return redirect()->route('contractors.index')->with('success', trans('admin/contractors/message.create.success'));
        }
        return redirect()->back()->withInput()->withErrors($contractor->getErrors());
    }

    /**
     * contractor update.
     *
     * @param  int $contractorId
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($contractorId = null)
    {
        // $this->authorize('update', Contractor::class);
        // Check if the Contractor exists
        if (is_null($item = Contractor::find($contractorId))) {
            // Redirect to the Contractor  page
            return redirect()->route('contractors.index')->with('error', trans('admin/contractors/message.does_not_exist'));
        }

        // Show the page
        return view('contractors/edit', compact('item'));
    }

    // testing add project

      /**
     * contractor add project .
     *
     * @param  int $contractorId
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function addproject($contractorId = null)
    {
        // $this->authorize('update', Contractor::class);
        // Check if the Contractor exists
        if (is_null($item = Contractor::find($contractorId))) {
            // Redirect to the Contractor  page
            return redirect()->route('contractors.index')->with('error', trans('admin/contractors/message.does_not_exist'));
        }

        // Show the page
        return view('contractors/addproject', compact('item'));
    }




    /**
     * Contractor update form processing page.
     *
     * @param  int $contractorId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update($contractorId, ImageUploadRequest $request)
    {
        // $this->authorize('update', Contractor::class);
        // Check if the contractor exists
        if (is_null($contractor = Contractor::find($contractorId))) {
            // Redirect to the contractor  page
            return redirect()->route('contractors.index')->with('error', trans('admin/contractors/message.does_not_exist'));
        }

        // Save the  data
        $contractor->company_id           = Company::getIdForCurrentUser($request->input('company_id'));
        $contractor->project_id           = request('project_id');
        $contractor->name                 = request('name');
        $contractor->address              = request('address');
        $contractor->address2             = request('address2');
        $contractor->city                 = request('city');
        $contractor->state                = request('state');
        $contractor->country              = request('country');
        $contractor->zip                  = request('zip');
        $contractor->contact              = request('contact');
        $contractor->phone                = request('phone');
        $contractor->fax                  = request('fax');
        $contractor->email                = request('email');
        $contractor->url                  = $contractor->addhttp(request('url'));
        $contractor->notes                = request('notes');
        $contractor = $request->handleImages($contractor);

        if ($contractor->save()) {
            return redirect()->route('contractors.index')->with('success', trans('admin/contractors/message.update.success'));
        }

        return redirect()->back()->withInput()->withErrors($contractor->getErrors());

    }

    /**
     * Delete the given contractor.
     *
     * @param  int $contractorId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($contractorId)
    {
        // $this->authorize('delete', Contractor::class);
        if (is_null($contractor = Contractor::find($contractorId))) {
            return redirect()->route('contractors.index')->with('error', trans('admin/contractors/message.not_found'));
        }


        // if ($contractor->assets_count > 0) {
        //     return redirect()->route('contractors.index')->with('error', trans('admin/contractors/message.delete.assoc_assets', ['asset_count' => (int) $contractor->assets_count]));
        // }

        // if ($contractor->asset_maintenances_count > 0) {
        //     return redirect()->route('contractors.index')->with('error', trans('admin/contractors/message.delete.assoc_maintenances', ['asset_maintenances_count' => $contractor->asset_maintenances_count]));
        // }

        // if ($contractor->licenses_count > 0) {
        //     return redirect()->route('contractors.index')->with('error', trans('admin/contractors/message.delete.assoc_licenses', ['licenses_count' => (int) $contractor->licenses_count]));
        // }

        $contractor->delete();
        return redirect()->route('contractors.index')->with('success',
            trans('admin/contractors/message.delete.success')
        );


    }


    /**
     *  Get the asset information to present to the contractor view page
     *
     * @param null $contractorId
     * @return \Illuminate\Contracts\View\View
     * @internal param int $assetId
     */
    public function show($contractorId = null)
    {
        $contractor = Contractor::find($contractorId);

        if (isset($contractor->id)) {
                return view('contractors/view', compact('contractor'));
        }

        return redirect()->route('contractors.index')->with('error', trans('admin/contractors/message.does_not_exist'));
    }

}
