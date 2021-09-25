<?php
namespace App\Http\Controllers;

use App\Http\Requests\ImageUploadRequest;
use App\Models\Client;
use App\Models\Supplier;
use App\Models\Company;
use App\Models\work;
use App\Models\contractor;
use Illuminate\Support\Facades\Auth;

/**
 * This controller handles all actions related to Clients for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 */
class ClientsController extends Controller
{
    /**
     * Show a list of all clients
     *
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        // Grab all the clients
        $this->authorize('view', Client::class);
        $clientcount = new Client;
        $contractorcount = new Contractor;
        $suppliercount = new Supplier;


        $counts['client']   =  $clientcount     ->count_by_company();
        $counts['contractor']   =  $contractorcount     ->count_by_company();

        $counts['project'] = \App\Models\Project::count();
        $counts['supplier'] = \App\Models\Supplier::count();

        // $counts['supplier'] = $suppliercount  ->count_by_company();

        // $counts['contractor'] = \App\Models\Contractor::count();
        // $counts['client'] = \App\Models\Client::count(); 
        // Show the page
        return view('clients/index')->with('counts', $counts);
    }


    /**
     * client create.
     *
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Client::class);
        return view('clients/edit')->with('item', new Client);
    }


    /**
     * Client create form processing.
     *
     * @param ImageUploadRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(ImageUploadRequest $request)
    {
        $this->authorize('create', Client::class);
        // Create a new client
        $client = new Client;
        // Save the location data

        $client->company_id       = Company::getIdForCurrentUser($request->input('company_id'));
        $client->name                 = request('name');
        $client->department            = request('department');
        $client->address              = request('address');
        $client->address2             = request('address2');
        $client->city                 = request('city');
        $client->state                = request('state');
        $client->country              = request('country');
        $client->zip                  = request('zip');
        $client->contact              = request('contact');
        $client->phone                = request('phone');
        $client->fax                  = request('fax');
        $client->email                = request('email');
        $client->notes                = request('notes');
        $client->url                  = $client->addhttp(request('url'));
        $client->user_id              = Auth::id();
        $client = $request->handleImages($client);


        if ($client->save()) {
            return redirect()->route('clients.index')->with('success', trans('admin/clients/message.create.success'));
        }
        return redirect()->back()->withInput()->withErrors($client->getErrors());
    }

    /**
     * client update.
     *
     * @param  int $clientId
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($clientId = null)
    {
        $this->authorize('update', Client::class);
        // Check if the client exists
        if (is_null($item = Client::find($clientId))) {
            // Redirect to the client  page
            return redirect()->route('clients.index')->with('error', trans('admin/clients/message.does_not_exist'));
        }

        // Show the page
        return view('clients/edit', compact('item'));
    }


    /**
     * client update form processing page.
     *
     * @param  int $clientId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update($clientId, ImageUploadRequest $request)
    {
        $this->authorize('update', Client::class);
        // Check if the client exists
        if (is_null($client = Client::find($clientId))) {
            // Redirect to the client  page
            return redirect()->route('clients.index')->with('error', trans('admin/clients/message.does_not_exist'));
        }

        // Save the  data
        $client->company_id       = Company::getIdForCurrentUser($request->input('company_id'));
        $client->name                 = request('name');
        $client->department            = request('department');
        $client->address              = request('address');
        $client->address2             = request('address2');
        $client->city                 = request('city');
        $client->state                = request('state');
        $client->country              = request('country');
        $client->zip                  = request('zip');
        $client->contact              = request('contact');
        $client->phone                = request('phone');
        $client->fax                  = request('fax');
        $client->email                = request('email');
        $client->url                  = $client->addhttp(request('url'));
        $client->notes                = request('notes');
        $client = $request->handleImages($client);

        if ($client->save()) {
            return redirect()->route('clients.index')->with('success', trans('admin/clients/message.update.success'));
        }

        return redirect()->back()->withInput()->withErrors($client->getErrors());

    }

    /**
     * Delete the given client.
     *
     * @param  int $clientId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($clientId)
    {
        $this->authorize('delete', Client::class);
        if (is_null($client = Client::find($clientId))) {
            return redirect()->route('clients.index')->with('error', trans('admin/clients/message.not_found'));
        }


        // if ($client->assets_count > 0) {
        //     return redirect()->route('clients.index')->with('error', trans('admin/clients/message.delete.assoc_assets', ['asset_count' => (int) $client->assets_count]));
        // }

        // if ($client->asset_maintenances_count > 0) {
        //     return redirect()->route('clients.index')->with('error', trans('admin/clients/message.delete.assoc_maintenances', ['asset_maintenances_count' => $client->asset_maintenances_count]));
        // }

        // if ($client->licenses_count > 0) {
        //     return redirect()->route('clients.index')->with('error', trans('admin/clients/message.delete.assoc_licenses', ['licenses_count' => (int) $client->licenses_count]));
        // }

        $client->delete();
        return redirect()->route('clients.index')->with('success',
            trans('admin/clients/message.delete.success')
        );


    }


    /**
     *  Get the asset information to present to the client view page
     *
     * @param null $clientId
     * @return \Illuminate\Contracts\View\View
     * @internal param int $assetId
     */
    public function show($clientId = null)
    {
        $client = Client::find($clientId);

        if (isset($client->id)) {
                return view('clients/view', compact('client'));
        }

        return redirect()->route('clients.index')->with('error', trans('admin/clients/message.does_not_exist'));
    }

}
