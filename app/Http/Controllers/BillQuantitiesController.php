<?php
namespace App\Http\Controllers;

use App\Http\Requests\ImageUploadRequest;
use App\Models\Company;
use App\Models\User;
use App\Models\Project;
use App\Models\BillQuantity;
use App\Models\File;
use App\Helpers\Helper;


use Illuminate\Support\Facades\Auth;

/**
 * This controller handles all actions related to BillQuantities for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 */
class BillQuantitiesController extends Controller
{
    /**
     * Show a list of all BillQuantities
     *
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        // Grab all the BillQuantities
        $this->authorize('view', BillQuantity::class);
 
        // Show the page
        return view('billquantities/index');
    }


    /**
     * billquantity create.
     *
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', BillQuantity::class);
        return view('billquantities/edit')->with('item', new BillQuantity);
    }


    /**
     * billquantity create form processing.
     *
     * @param ImageUploadRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(ImageUploadRequest $request)
    {
        $this->authorize('create', BillQuantity::class);
        // Create a new billquantity
        $projectfiles = new File;
        $billquantity = new BillQuantity;
        // Save the location data

        $billquantity->company_id           = Company::getIdForCurrentUser($request->input('company_id'));
        $billquantity->user_id              = Auth::id();
        $billquantity->project_id            = request('project_id');

        $billquantity->name                 = request('name');
        $billquantity->brand                 = request('brand');

        $billquantity->modelNo              = request('modelNo');
        $billquantity->serial               = request('serial');
        $billquantity->type                 = request('type');
        // $billquantity->sale_value           = request('sale_value');

        $billquantity->sale_value           = Helper::ParseFloat($request->get('sale_value'));

        // $billquantity->buy_value            = request('buy_value');
        $billquantity->buy_value            = Helper::ParseFloat($request->get('buy_value'));

        $billquantity->net_profit           = request('net_profit');
        $billquantity->option               = request('option');
        $billquantity->remark               = request('remark');
        $billquantity->filename             = request('filename');


        $request->validate([
            'file' => 'mimes:csv,txt,xlx,xls,pdf,|max:2048'
            ]);
    
            // $fileModel = new SubtaskFile;
    
            if($request->file()) {
                $fileName = $request->input('filename').'.'.$request->file->getClientOriginalExtension();
                $filePath = $request->file('file')->storeAs('bom', $fileName, 'public');
    
                $billquantity->filename = $request->input('filename').'.'.$request->file->getClientOriginalExtension();
                $billquantity->name = $request->input('filename');
                $billquantity->file_path = '/storage/' . $filePath;

                $fileName = $request->input('filename').'.'.$request->file->getClientOriginalExtension();
                $filePath = $request->file('file')->storeAs('project_files', $fileName, 'public');

                $projectfiles->filename = $request->input('filename').'.'.$request->file->getClientOriginalExtension();
                $projectfiles->name = $request->input('filename');
                $projectfiles->file_location = ('Bill of Material');
                $projectfiles->file_path = '/storage/' . $filePath;
                $projectfiles->project_id    = request('project_id');
                $projectfiles->save();
    
            }
     
        // $billquantity = $request->handleImages($billquantity);


        if ($billquantity->save()) {

            $projectId = $billquantity->project_id;

            $project = Project::find($projectId);

            return redirect()->route('projectsreroute', ['projectid' => $projectId])->with('success',trans('admin/billquantities/message.create.success'));

            // return redirect()->route('projectsreroute', ['projectid' => $projectId],'/#billquantities')->with('success',trans('admin/billquantities/message.create.success'));

            // return redirect()->route('billquantities.index')->with('success', trans('admin/billquantities/message.create.success'));
        }
        // dd($request->all());
        return redirect()->back()->withInput()->withErrors($billquantity->getErrors());
    }


    /**
     * billquantity update.
     *
     * @param  int $billquantityId
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($billquantityId = null)
    {
        $this->authorize('update', BillQuantity::class);
        // Check if the billquantity exists
        if (is_null($item = BillQuantity::find($billquantityId))) {
            // Redirect to the billquantity  page
            return redirect()->route('billquantities.index')->with('error', trans('admin/billquantities/message.does_not_exist'));
        }

        // Show the page
        return view('billquantities/edit', compact('item'));
    }


    /**
     * billquantity update form processing page.
     *
     * @param  int $billquantityId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update($billquantityId, ImageUploadRequest $request)
    {
        $this->authorize('update', BillQuantity::class);
        // Check if the billquantity exists
        if (is_null($billquantity = BillQuantity::find($billquantityId))) {
            // Redirect to the billquantity  page
            return redirect()->route('billquantities.index')->with('error', trans('admin/billquantities/message.does_not_exist'));
        }

        // Save the  data
        $billquantity->company_id       = Company::getIdForCurrentUser($request->input('company_id'));
        $billquantity->name                 = request('name');
        $billquantity->sale_value           = request('sale_value');
        $billquantity->buy_value            = request('buy_value');

   
        // $billquantity = $request->handleImages($billquantity);

        if ($billquantity->save()) {
            // return redirect()->route('billquantities.index')->with('success', trans('admin/billquantities/message.update.success'));
            $projectId = $billquantity->project_id;

            $project = Project::find($projectId);

            return redirect()->route('projectsreroute', ['projectid' => $projectId])->with('success',trans('admin/billquantities/message.create.success'));

        }

        return redirect()->back()->withInput()->withErrors($billquantity->getErrors());

    }

    /**
     * Delete the given billquantity.
     *
     * @param  int $billquantityId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($billquantityId)
    {
        $this->authorize('delete', BillQuantity::class);
        if (is_null($billquantity = BillQuantity::find($billquantityId))) {
            return redirect()->route('billquantities.index')->with('error', trans('admin/billquantities/message.not_found'));
        }


        // if ($billquantity->assets_count > 0) {
        //     return redirect()->route('billquantities.index')->with('error', trans('admin/billquantities/message.delete.assoc_assets', ['asset_count' => (int) $billquantity->assets_count]));
        // }

        // if ($billquantity->asset_maintenances_count > 0) {
        //     return redirect()->route('billquantities.index')->with('error', trans('admin/billquantities/message.delete.assoc_maintenances', ['asset_maintenances_count' => $billquantity->asset_maintenances_count]));
        // }

        // if ($billquantity->licenses_count > 0) {
        //     return redirect()->route('billquantities.index')->with('error', trans('admin/billquantities/message.delete.assoc_licenses', ['licenses_count' => (int) $billquantity->licenses_count]));
        // }

        $billquantity->delete();

        $projectId = $billquantity->project_id;

        $project = Project::find($projectId);

        return redirect()->route('projectsreroute', ['projectid' => $projectId])->with('success',trans('admin/billquantities/message.delete.success'));


        // return redirect()->route('billquantities.index')->with('success', trans('admin/billquantities/message.delete.success'));


    }


    /**
     *  Get the asset information to present to the billquantity view page
     *
     * @param null $billquantityId
     * @return \Illuminate\Contracts\View\View
     * @internal param int $assetId
     */
    public function show($billquantityId = null)
    {
        $billquantity = BillQuantity::find($billquantityId);

        if (isset($billquantity->id)) {
                return view('billquantities/view', compact('billquantity'));
        }

        return redirect()->route('billquantities.index')->with('error', trans('admin/billquantities/message.does_not_exist'));
    }

}
