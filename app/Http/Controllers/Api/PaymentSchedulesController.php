<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;

use App\Http\Controllers\Controller;
use App\Http\Transformers\PaymentSchedulesTransformer;
use App\Http\Transformers\SelectlistTransformer;
use App\Models\PaymentSchedules;

use App\Models\Company;
use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;
use Auth;
use DB;

use Illuminate\Http\Request;

class PaymentSchedulesController extends Controller
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
        $this->authorize('view', PaymentSubtask::class);
        $allowed_columns = ['id','details','created_at','user_id','project_id'];

        
        $paymentschedules = PaymentSubtask::select('paymentschedules.*');

        if ($request->filled('search')) {
            $paymentschedules = $paymentschedules->TextSearch($request->input('search'));
        }

        if ($request->filled('project_id')) {
            $paymentschedules->where('project_id','=',$request->input('project_id'));
        }

        if ($request->filled('user_id')) {
            $paymentschedules->where('user_id','=',$request->input('user_id'));
        }

        if ($request->filled('subtask_id')) {
            $paymentschedules->where('subtask_id','=',$request->input('subtask_id'));
        }

        // Set the offset to the API call's offset, unless the offset is higher than the actual count of items in which
        // case we override with the actual count, so we should return 0 items.
        $offset = (($paymentschedules) && ($request->get('offset') > $paymentschedules->count())) ? $paymentschedules->count() : $request->get('offset', 0);

        // Check to make sure the limit is not higher than the max allowed
        ((config('app.max_results') >= $request->input('limit')) && ($request->filled('limit'))) ? $limit = $request->input('limit') : $limit = config('app.max_results');


        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';


        $total = $paymentschedules->count();
        $paymentschedules = $paymentschedules->skip($offset)->take($limit)->get();
        return (new PaymentSchedulesTransformer)->transformPaymentSchedules($paymentschedules, $total);
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
        $this->authorize('create', PaymentSubtask::class);
        $paymentsubtask = new PaymentSubtask;
        $paymentsubtask->fill($request->all());

        if ($paymentsubtask->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $paymentsubtask, trans('admin/paymentsubtasks/message.create.success')));
        }
        return response()->json(Helper::formatStandardApiResponse('error', null, $paymentsubtask->getErrors()));

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
        //$this->authorize('view', paymentsubtask::class);
        $paymentsubtask = PaymentSubtask::findOrFail($id);
        return (new paymentsubtasksTransformer)->transformPaymentSubtask($paymentsubtask);
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
        //$this->authorize('update', paymentsubtask::class);
        $paymentsubtask = PaymentSubtask::findOrFail($id);
        $paymentsubtask->fill($request->all());

        if ($paymentsubtask->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $paymentsubtask, trans('admin/paymentsubtasks/message.update.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $paymentsubtask->getErrors()));
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
        //$this->authorize('delete', PaymentSubtask::class);
        $paymentsubtask = PaymentSubtask::findOrFail($id);
        $this->authorize($paymentsubtask);

        if ($paymentsubtask->hasUsers() > 0) {
            return response()->json(Helper::formatStandardApiResponse('error', null,  trans('admin/paymentsubtasks/message.assoc_users', array('count'=> $paymentsubtask->hasUsers()))));
        }

        $paymentsubtask->delete();
        return response()->json(Helper::formatStandardApiResponse('success', null,  trans('admin/paymentsubtasks/message.delete.success')));

    }

}
