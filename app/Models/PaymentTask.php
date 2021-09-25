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


class PaymentTask extends SnipeModel
{
    protected $presenter = 'App\Presenters\PaymentTaskPresenter';
    use Presentable;
    use SoftDeletes;
    protected $dates = [
        'created_at',
        'updated_at',
        'payment_period',
    ];


    protected $table ='paymenttasks';

    protected $rules = array(
        
        'details'       => 'string|nullable',
    );

    protected $casts = [
        'project_id'             => 'integer',
        'task_id'                => 'integer',
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
    'details',
    'payment_period',
    'project_id',
    'task_id',
    'supplier_id',
    'contractor_id',
    'user_id',



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
        'created_at',
    
         
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
    //end add

 
    /**
     * Establishes the PaymentTask ->Task relationship
     *
    
     * @since [v2.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function Task()
    {
        return $this->belongsTo('\App\Models\Task', 'task_id');
    }
    
    public function user()
    {
        return $this->belongsTo('\App\Models\User', 'user_id');
    }
    /**
     * Establishes the PaymentTask -> contractor relationship
     *
    
     * @since [v2.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function contractor()
    {
        return $this->belongsTo('\App\Models\Contractor', 'contractor_id');
    }

  /**
     * Establishes the PaymentTask -> supplier relationship
     *
    
     * @since [v2.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function supplier()
    {
        return $this->belongsTo('\App\Models\Supplier', 'supplier_id');
    }


}
