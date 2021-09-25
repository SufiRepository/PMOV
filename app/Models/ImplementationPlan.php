<?php
namespace App\Models;

use App\Http\Traits\UniqueUndeletedTrait;
use App\Models\Asset;
use App\Models\Contractor;
use App\Models\Supplier;

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
use Illuminate\Support\Facades\Log;


class ImplementationPlan extends SnipeModel
{
    protected $presenter = 'App\Presenters\ImplementationPlanPresenter';
    use Presentable;
    use SoftDeletes;
    protected $dates = [
        'deleted_at',
        'created_at',
    
        'contract_start_date',
        'contract_end_date',
        'actual_start_date',
        'actual_end_date',
    ];


    protected $table ='implementationplans';

    protected $rules = array(
        'name'          => 'required|min:2|max:255',
        'details'       => 'string|nullable',
        'project_id'    => 'integer|nullable',
        'company_id'    => 'integer|nullable',

      


    );

    protected $casts = [
        'project_id'    => 'integer',
        'company_id'    => 'integer',
        'user_id'       => 'integer',
        'status_id'     => 'integer',


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
    'name',
    'details',   

    'contract_start_date',
    'contract_end_date',
    'actual_start_date',
    'actual_end_date',
    'contract_duration',
    'actual_duration',
    
    'company_id',   
    'project_id',
    'user_id',
    'status_id',

    ];
    protected $hidden = ['user_id'];

    use Searchable;
    
    /**
     * The attributes that should be included when searching the model.
     * 
     * @var array
     */
    protected $searchableAttributes = [
        'name',
        'contract_start_date',
        'contract_end_date',
        'actual_start_date',
        'actual_end_date',
    ];

    /**
     * The relations and their attributes that should be included when searching the model.
     * 
     * @var array
     */
    protected $searchableRelations = [
    ];

    public function isDeletable()
    {
        return Gate::allows('delete', $this);
                // && ($this->assignedAssets()->count()===0)
                // && ($this->projects()()->count()===0)
                // && ($this->users()->count()===0);
    }


//Untuk count task,sekiranya superuser dia akan list all,and untuk admin dia akan count untuk project dia shj
public function count_by_project () {

    // $user = new User;

    // $project = Project::find($projectId);

    // if (Auth::user()->isSuperUser()) {
    //     return DB::table('tasks')
    //             ->select('tasks.*')
    //             ->where('tasks.deleted_at','=',null)
    //             ->count();
    // } else {
        
    // return DB::table('task as a')
    //             ->leftJoin('users as b','a.project_id','=','b.project_id ')
    //             ->where('b.id', Auth::id())
    //             ->where('a.deleted_at','=',null)
    //             ->count();

    //             // return Task::whereNull('deleted_at')
    //             // ->count();
    // }

}
// end asset count



    public function users()
    {
        return $this->hasMany('\App\Models\User', 'implementationplan_id');
    }
    // new add by farez 27/5/2021
    public function projects()
    {
        return $this->hasMany('\App\Models\Project', 'implementationplan_id');
    }
    //end add

     // new add by farez 8/2/2021
     public function company()
     {
         return $this->hasMany('\App\Models\Company', 'implementationplan_id');
     }
     //end add

    public function assets()
    {
        return $this->hasMany('\App\Models\Asset', 'implementationplan_id');
    }

 /**
     * Establishes the implementationplans -> status relationship
     *
     * @author farez@mindwave.my
     * @since [v1.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function implementationstatus()
    {
        return $this->belongsTo('\App\Models\Statuslabel', 'status_id');
    }

  

    // // new add by farez 27/5/2021
    // public function project()
    // {
    //     return $this->hasMany('\App\Models\Project', 'location_id');
    // }
    // //end add

    // public function children() {
    //     return $this->hasMany('\App\Models\Task','parent_id')
    //         ->with('children');
    // }


    /**
     * Establishes the project -> contractor relationship
     *
     * @author farez@mindwave.com
     * @since [v2.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function contractor()
    {
        return $this->belongsTo('\App\Models\Contractor', 'contractor_id');
    }

    /**
     * Establishes the project -> supplier relationship
     *
     * @author farez@mindwave.com
     * @since [v2.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function supplier()
    {
        return $this->belongsTo('\App\Models\Supplier', 'supplier_id');
    }

    public function setLdapOuAttribute($ldap_ou)
    {
        return $this->attributes['ldap_ou'] = empty($ldap_ou) ? null : $ldap_ou;
    }



  


     /**
     * Sets expiration date attribute
     *
     * @author farez@mindwave.my
     * @since [v1.0]
     * @return mixed
     */
    public function setDueDateAttribute($value)
    {

        if ($value == '' || $value == '0000-00-00') {
            $value = null;
        } else {
            $value = (new Carbon($value))->toDateString();
        }
        $this->attributes['due_date'] = $value;
    }


    /**
     * Query builder scope to order on manager name
     *
     * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
     * @param  text                              $order       Order
     *
     * @return \Illuminate\Database\Query\Builder          Modified query builder
     */
    public function scopeOrderManager($query, $order)
    {
        return $query->leftJoin('users as implementationplan_user', 'implementationplans.manager_id', '=', 'implementationplan_user.id')->orderBy('implementationplan_user.first_name', $order)->orderBy('implementationplan_user.last_name', $order);
    }

    /**
    * Query builder scope to order on project
    *
    * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
    * @param  text $order  Order
    * @return \Illuminate\Database\Query\Builder Modified query builder
    */
    public function scopeOrderProject($query, $order)
    {
        return $query->leftJoin('projects as project_sort', 'implementationplans.company_id', '=', 'project_sort.id')->orderBy('project_sort.name', $order);
    }

     /**
     * Query builder scope to order on company
     *
     * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
     * @param  text                              $order         Order
     *
     * @return \Illuminate\Database\Query\Builder          Modified query builder
     */
    public function scopeOrderCompany($query, $order)
    {
        return $query->leftJoin('companies as companies', 'implementationplan.company_id', '=', 'companies.id')->select('implementationplan.*')
            ->orderBy('companies.name', $order);
    }


       /**
     * Returns expiring Implementationplan
     *
     * @todo should refactor. I don't like get() in model methods
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v1.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public static function getExpiringImplementationPlan($days = 60)
    {

        return Implementationplan::whereNotNull('contract_end_date')
        ->whereNull('deleted_at')
        ->whereRaw(DB::raw('DATE_SUB(`contract_end_date`,INTERVAL '.$days.' DAY) <= DATE(NOW()) '))
        ->where('contract_end_date', '>', date("Y-m-d"))
        ->orderBy('contract_end_date', 'ASC')
        ->get();

    }
}
