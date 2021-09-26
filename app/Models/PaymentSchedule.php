<?php
namespace App\Models;

use App\Http\Traits\UniqueUndeletedTrait;
use App\Models\Asset;
use App\Models\Contractor;
use App\Models\Project;
use App\Models\SnipeModel;
use App\Models\Traits\Searchable;
use App\Models\User;
use App\Presenters\Presentable;
use DB;
use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Gate;
use Watson\Validating\ValidatingTrait;


use App\Events\AssetCheckedOut;
use App\Events\CheckoutableCheckedOut;
use App\Exceptions\CheckoutNotAllowed;
use App\Http\Traits\UniqueSerialTrait;
use App\Models\Traits\Acceptable;

use AssetPresenter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Support\Facades\Storage;


class PaymentSchedule extends SnipeModel
{
    protected $presenter = 'App\Presenters\PaymentSchedulePresenter';
    use Presentable;
    use SoftDeletes;
    protected $dates = [
        'created_at',
        'updated_at',
        'payment_period',
    ];


    protected $table ='paymentschedules';

    protected $rules = array(
        'name'               => 'string',

    );

    protected $casts = [
        'project_id'             => 'integer',
        'implementationplan_id'  => 'integer',
        'supplier_id'            => 'integer',
        'contractor_id'          => 'integer',
        'user_id'                => 'integer',

      
    ];

    /**
    * Whether the model should inject it's identifier to the unique
    * validation rules before attempting validation. If this property
    * is not set in the model it will default to true.
    *
    * @var boolean
    */
    protected $injectUniqueIdentifier = true;
    use ValidatingTrait;
    use UniqueUndeletedTrait;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_id',
        'implementationplan_id',
        'task_id',
        'subtask_id',
        'contractor_id',
        'amount',
        'description',
        'task_name',
        
        // 'purchaseorder_no',
        // 'file_purchaseorder_no',
        // 'invoice_no',
        // 'file_invoice_no',
        // 'paymentreference_no',
        // 'file_paymentreference_no',

        'paymentdate',
        'amount',
        'paymentstatus',


    ];
    protected $hidden = ['user_id'];

    use Searchable;
    
    /**
     * The attributes that should be included when searching the model.
     * 
     * @var array
     */
    protected $searchableAttributes = [
        'paymentdate',
        'amount',
    ];

    /**
     * The relations and their attributes that should be included when searching the model.
     * 
     * @var array
     */
    protected $searchableRelations = [
      'parent' => ['name']
    ];



    public function users()
    {
        return $this->hasMany('\App\Models\User', 'user_id');
    }
  
    public function project()
    {
        return $this->belongsTo('\App\Models\Project', 'project_id');
    }
    public function task()
    {
        return $this->hasMany('\App\Models\Task', 'task_id');
    }
}
