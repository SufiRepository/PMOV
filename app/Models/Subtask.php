<?php
namespace App\Models;

use App\Http\Traits\UniqueUndeletedTrait;
use App\Models\SnipeModel;
use App\Models\Traits\Searchable;
use App\Models\User;
use App\Models\Task;
use App\Models\Contractor;
use App\Presenters\Presentable;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Gate;
use Watson\Validating\ValidatingTrait;

class Subtask extends SnipeModel
{
    protected $presenter = 'App\Presenters\SubtaskPresenter';
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


    protected $table ='subtasks';

    protected $rules = array(
        'name'          => 'required|min:2|max:255',
        'details'       => 'string|nullable',
        'company_id'    => 'integer|nullable',
        'task_id'       => 'integer|nullable',

    );

    protected $casts = [
        'company_id'    => 'integer',
        'task_id'       => 'integer',
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
    'task_id',
    'status_id',
    'priority',
 

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
      'parent' => ['name']
    ];

    public function isDeletable()
    {
        return Gate::allows('delete', $this);
                // && ($this->assignedAssets()->count()===0)
                // && ($this->projects()()->count()===0)
                // && ($this->users()->count()===0);
    }

    public function tasks()
    {
        return $this->hasMany('\App\Models\Task', 'subtask_id');
    }

    public function users()
    {
        return $this->hasMany('\App\Models\User', 'subtask_id');
    }
    // new add by farez 27/5/2021
    public function projects()
    {
        return $this->hasMany('\App\Models\Project', 'subtask_id');
    }
    //end add

     // new add by farez 8/2/2021
     public function company()
     {
         return $this->hasMany('\App\Models\Company', 'subtask_id');
     }
     //end add

    public function assets()
    {
        return $this->hasMany('\App\Models\Asset', 'subtask_id');
    }

    // public function parent()
    // {
    //     return $this->belongsTo('\App\Models\Task', 'parent_id','id')
    //         ->with('parent');
    // }

    public function manager()
    {
        return $this->belongsTo('\App\Models\User', 'manager_id');
    }

   


    public function setLdapOuAttribute($ldap_ou)
    {
        return $this->attributes['ldap_ou'] = empty($ldap_ou) ? null : $ldap_ou;
    }


    /**
     * Query builder scope to order on parent
     *
     * @param  Illuminate\Database\Query\Builder  $query  Query builder instance
     * @param  text                              $order       Order
     *
     * @return Illuminate\Database\Query\Builder          Modified query builder
     */

    public static function indenter($tasks_with_children, $parent_id = null, $prefix = '') {
        $results = Array();

        
        if (!array_key_exists($parent_id, $tasks_with_children)) {
            return [];
        }


        foreach ($tasks_with_children[$parent_id] as $task) {
            $task->use_text = $prefix.' '.$task->name;
            $task->use_image = ($task->image) ? url('/').'/uploads/tasks/'.$task->image : null;
            $results[] = $task;
            //now append the children. (if we have any)
            if (array_key_exists($task->id, $tasks_with_children)) {
                $results = array_merge($results, Task::indenter($tasks_with_children, $task->id,$prefix.'--'));
            }
        }
        return $results;
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
     * Establishes the tasks -> status relationship
     *
     * @author farez@mindwave.my
     * @since [v1.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function statustask()
    {
        return $this->belongsTo('\App\Models\StatusTask', 'statustask_id');
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
    /**
    * Query builder scope to order on parent
    *
    * @param  Illuminate\Database\Query\Builder  $query  Query builder instance
    * @param  text                              $order       Order
    *
    * @return Illuminate\Database\Query\Builder          Modified query builder
    */
    public function scopeOrderParent($query, $order)
    {
      // Left join here, or it will only return results with parents
        return $query->leftJoin('tasks as parent_loc', 'tasks.parent_id', '=', 'parent_loc.id')->orderBy('parent_loc.name', $order);
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
        return $query->leftJoin('users as task_user', 'tasks.manager_id', '=', 'task_user.id')->orderBy('task_user.first_name', $order)->orderBy('task_user.last_name', $order);
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
        return $query->leftJoin('projects as project_sort', 'tasks.company_id', '=', 'project_sort.id')->orderBy('project_sort.name', $order);
    }

      /**
     * Establishes the subtask -> contractor relationship
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
     * Establishes the subtask -> paymentsubtask relationship
     *
     * @author farez@mindwave.com
     * @since [v2.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function paymentsubtask()
    {
        return $this->belongsTo('\App\Models\Paymentsubtask', 'paymentsubtask_id');
    }


       /**
     * Establishes the subtask -> task relationship
     *
     * @author farez@mindwave.com
     * @since [v2.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function task()
    {
        return $this->belongsTo('\App\Models\Task', 'task_id');
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
        return $query->leftJoin('companies as companies', 'task.company_id', '=', 'companies.id')->select('task.*')
            ->orderBy('companies.name', $order);
    }


     /**
     * Returns expiring licenses
     *
     * @todo should refactor. I don't like get() in model methods
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v1.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public static function getExpiringSubtasks($days = 60)
    {

        return License::whereNotNull('contract_end_date')
        ->whereNull('deleted_at')
        ->whereRaw(DB::raw('DATE_SUB(`contract_end_date`,INTERVAL '.$days.' DAY) <= DATE(NOW()) '))
        ->where('contract_end_date', '>', date("Y-m-d"))
        ->orderBy('contract_end_date', 'ASC')
        ->get();

    }
    
}
