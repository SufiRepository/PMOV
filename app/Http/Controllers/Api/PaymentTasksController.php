<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;

use App\Http\Controllers\Controller;
use App\Http\Transformers\paymenttasksTransformer;
use App\Http\Transformers\SelectlistTransformer;
use App\Models\PaymentTask;

use App\Models\Company;
use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;
use Auth;
use DB;

use Illuminate\Http\Request;

class PaymentTasksController extends Controller
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
        $this->authorize('view', PaymentTask::class);
        $allowed_columns = ['id','details','created_at','user_id','project_id'];

        
        $paymenttasks = PaymentTask::select('paymenttasks.*');

        if ($request->filled('search')) {
            $paymenttasks = $paymenttasks->TextSearch($request->input('search'));
        }

        if ($request->filled('project_id')) {
            $paymenttasks->where('project_id','=',$request->input('project_id'));
        }

        if ($request->filled('user_id')) {
            $paymenttasks->where('user_id','=',$request->input('user_id'));
        }

        if ($request->filled('task_id')) {
            $paymenttasks->where('task_id','=',$request->input('task_id'));
        }

        // Set the offset to the API call's offset, unless the offset is higher than the actual count of items in which
        // case we override with the actual count, so we should return 0 items.
        $offset = (($paymenttasks) && ($request->get('offset') > $paymenttasks->count())) ? $paymenttasks->count() : $request->get('offset', 0);

        // Check to make sure the limit is not higher than the max allowed
        ((config('app.max_results') >= $request->input('limit')) && ($request->filled('limit'))) ? $limit = $request->input('limit') : $limit = config('app.max_results');


        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';


        $total = $paymenttasks->count();
        $paymenttasks = $paymenttasks->skip($offset)->take($limit)->get();
        return (new PaymentTasksTransformer)->transformPaymentTasks($paymenttasks, $total);
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
        $this->authorize('create', PaymentTask::class);
        $paymenttask = new PaymentTask;
        $paymenttask->fill($request->all());

        if ($paymenttask->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $paymenttask, trans('admin/paymenttasks/message.create.success')));
        }
        return response()->json(Helper::formatStandardApiResponse('error', null, $paymenttask->getErrors()));

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
        //$this->authorize('view', paymenttask::class);
        $paymenttask = PaymentTask::findOrFail($id);
        return (new PaymenTtasksTransformer)->transformPaymentTasks($paymenttask);
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
        //$this->authorize('update', paymenttask::class);
        $paymenttask = PaymentTask::findOrFail($id);
        $paymenttask->fill($request->all());

        if ($paymenttask->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $paymenttask, trans('admin/paymenttasks/message.update.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $paymenttask->getErrors()));
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
        //$this->authorize('delete', paymenttask::class);
        $paymenttask = PaymentTask::findOrFail($id);
        $this->authorize($paymenttask);

        if ($paymenttask->hasUsers() > 0) {
            return response()->json(Helper::formatStandardApiResponse('error', null,  trans('admin/paymenttasks/message.assoc_users', array('count'=> $paymenttask->hasUsers()))));
        }

        $paymenttask->delete();
        return response()->json(Helper::formatStandardApiResponse('success', null,  trans('admin/paymenttasks/message.delete.success')));

    }

}
