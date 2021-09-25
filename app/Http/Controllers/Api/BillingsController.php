<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;

use App\Http\Controllers\Controller;
use App\Http\Transformers\BillingsTransformer;
use App\Http\Transformers\SelectlistTransformer;
use App\Models\Billing;

use App\Models\Company;
use App\Models\Task;
use App\Models\User;
use App\models\Contactor;

use Carbon\Carbon;
use Auth;
use DB;

use Illuminate\Http\Request;

class BillingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', Billing::class);
        $allowed_columns = [
            'id',
            'descriptions',
            'project_id',
            'task_id',
        ];

        
        $billings = Billing::select('billings.*');

        if ($request->filled('search')) {
            $billings = $billings->TextSearch($request->input('search'));
        }

        if ($request->filled('task_id')) {
            $billings->where('task_id','=',$request->input('task_id'));
        }

        if ($request->filled('user_id')) {
            $billings->where('user_id','=',$request->input('user_id'));
        }


        // Set the offset to the API call's offset, unless the offset is higher than the actual count of items in which
        // case we override with the actual count, so we should return 0 items.
        $offset = (($billings) && ($request->get('offset') > $billings->count())) ? $billings->count() : $request->get('offset', 0);

        // Check to make sure the limit is not higher than the max allowed
        ((config('app.max_results') >= $request->input('limit')) && ($request->filled('limit'))) ? $limit = $request->input('limit') : $limit = config('app.max_results');


        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';


        $total = $billings->count();
        $billings = $billings->skip($offset)->take($limit)->get();
        return (new BillingsTransformer)->transformBillings($billings, $total);
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
        $this->authorize('create', Billing::class);
        $billing = new Billing;
        $billing->fill($request->all());

        if ($billing->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $billing, trans('admin/billings/message.create.success')));
        }
        return response()->json(Helper::formatStandardApiResponse('error', null, $billing->getErrors()));

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
        //$this->authorize('view', Billing::class);
        $Billing = Billing::findOrFail($id);
        return (new billingsTransformer)->transformBilling($Billing);
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
        //$this->authorize('update', Billing::class);
        $Billing = Billing::findOrFail($id);
        $Billing->fill($request->all());

        if ($Billing->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $Billing, trans('admin/billings/message.update.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $Billing->getErrors()));
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
        //$this->authorize('delete', Billing::class);
        $Billing = Billing::findOrFail($id);
        $this->authorize($Billing);

        if ($Billing->hasUsers() > 0) {
            return response()->json(Helper::formatStandardApiResponse('error', null,  trans('admin/billings/message.assoc_users', array('count'=> $Billing->hasUsers()))));
        }

        $Billing->delete();
        return response()->json(Helper::formatStandardApiResponse('success', null,  trans('admin/billings/message.delete.success')));

    }

}
