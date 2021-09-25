<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Auth;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Transformers\HelpdesksTransformer;
use App\Http\Transformers\SelectlistTransformer;
use App\Models\Helpdesk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HelpdesksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @author [farez] [<farez@mindwave.my>]
     * @since [v4.0]
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $this->authorize('view', Helpdesk::class);
        $allowed_columns = [
                            'id',
                            'name',
                            'notes',
                            'created_at',
                            'updated_at',
                            'deleted_at',
                            'company_id',
                            'user_id',
                        ];

        // $helpdesks = Helpdesk::select(  array('id','name','notes','created_at','updated_at', 'deleted_at'));
        $user_company_id = Auth::user()->company_id;

        $helpdesks = Helpdesk::where('company_id', $user_company_id)->get();
        // )->withCount('assets as assets_count')->withCount('licenses as licenses_count')->withCount('consumables as consumables_count')->withCount('accessories as accessories_count');

        if ($request->input('deleted')=='true') {
            $helpdesks->onlyTrashed();
        }

        if ($request->filled('search')) {
            $helpdesks = $helpdesks->TextSearch($request->input('search'));
        }


        // Set the offset to the API call's offset, unless the offset is higher than the actual count of items in which
        // case we override with the actual count, so we should return 0 items.
        $offset = (($helpdesks) && ($request->get('offset') > $helpdesks->count())) ? $helpdesks->count() : $request->get('offset', 0);

        // Check to make sure the limit is not higher than the max allowed
        ((config('app.max_results') >= $request->input('limit')) && ($request->filled('limit'))) ? $limit = $request->input('limit') : $limit = config('app.max_results');

        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';
        // $helpdesks->orderBy($sort, $order);

        $total = $helpdesks->count();
        // $helpdesks = $helpdesks->skip($offset)->take($limit)->get();
        return (new HelpdesksTransformer)->transformHelpdesks($helpdesks);
        // return (new ManufacturersTransformer)->transformManufacturers($manufacturers, $total);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Helpdesk::class);
        $helpdesk = new Helpdesk;
        $helpdesk->fill($request->all());

        if ($helpdesk->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $helpdesk, trans('admin/helpdesks/message.create.success')));
        }
        return response()->json(Helper::formatStandardApiResponse('error', null, $helpdesk->getErrors()));

    }

    /**
     * Display the specified resource.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', Helpdesk::class);
        $helpdesk = Helpdesk::withCount('assets as assets_count')->withCount('licenses as licenses_count')->withCount('consumables as consumables_count')->withCount('accessories as accessories_count')->findOrFail($id);
        return (new HelpdesksTransformer)->transformHelpdesk($helpdesk);
    }


    /**
     * Update the specified resource in storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('update', Helpdesk::class);
        $helpdesk = Helpdesk::findOrFail($id);
        $helpdesk->fill($request->all());

        if ($helpdesk->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $helpdesk, trans('admin/helpdesks/message.update.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $helpdesk->getErrors()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $this->authorize('delete', Helpdesk::class);
        $helpdesk = Helpdesk::findOrFail($id);
        $this->authorize('delete', $helpdesk);

        if ($helpdesk->isDeletable()) {
            $helpdesk->delete();
            return response()->json(Helper::formatStandardApiResponse('success', null,  trans('admin/helpdesks/message.delete.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null,  trans('admin/helpdesks/message.assoc_users')));

    }

    /**
     * Gets a paginated collection for the select2 menus
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0.16]
     * @see \App\Http\Transformers\SelectlistTransformer
     *
     */
    public function selectlist(Request $request)
    {

        $helpdesks = Helpdesk::select([
            'id',
            'name',
            'issue',
        ]);

        if ($request->filled('search')) {
            $helpdesks = $helpdesks->where('name', 'LIKE', '%'.$request->get('search').'%');
        }

        $helpdesks = $helpdesks->orderBy('name', 'ASC')->paginate(50);

        // Loop through and set some custom properties for the transformer to use.
        // This lets us have more flexibility in special cases like assets, where
        // they may not have a ->name value but we want to display something anyway
        foreach ($helpdesks as $helpdesk) {
            $helpdesk->use_text = $helpdesk->name;
            // $helpdesk->use_image = ($helpdesk->image) ? Storage::disk('public')->url('manufacturers/'.$manufacturer->image, $manufacturer->image) : null;
        }

        return (new SelectlistTransformer)->transformSelectlist($helpdesks);

    }
}
