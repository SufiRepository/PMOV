<?php
namespace App\Models;

use App\Http\Traits\UniqueUndeletedTrait;
use App\Models\Asset;
use App\Models\Contractor;
use App\Models\Project;
use App\Models\Task;
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


class Billing extends SnipeModel
{
    protected $presenter = 'App\Presenters\BillingPresenter';
    use Presentable;
    use SoftDeletes;
    protected $dates = [
        
        'created_at',
        'updated_at',
        'billing_date',
    ];


    protected $table ='billings';

    protected $rules = array(
        
        'details'       => 'string|nullable',
    );

    protected $casts = [
        'task_id'    => 'integer',
        'user_id'    => 'integer',
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
    'details',
    'costing',
    'task_id',
    'invoice_no',
    'deliveryorder_no',
    'supportingdocument',
    'file_invoice',
    'file_deliveryorder',
    'file_supportingdocument',


    ];
    protected $hidden = ['user_id'];

    use Searchable;
    
    /**
     * The attributes that should be included when searching the model.
     * 
     * @var array
     */
    protected $searchableAttributes = [
        'details',
        'billing_date',

         
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
        return $this->hasMany('\App\Models\User', 'billing_id');
    }

    public function tasks()
    {
        return $this->belongsTo('\App\Models\Task', 'Task_id');
    }
  
    public function project()
    {
        return $this->belongsTo('\App\Models\Project', 'project_id');
    }
    //end add


}
