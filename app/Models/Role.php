<?php
namespace App\Models;

use App\Http\Traits\UniqueUndeletedTrait;
use App\Models\Asset;
use App\Models\Contractor;
use App\Models\Supplier;
use App\Models\Role;
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

// use Spatie\Permission\Traits\HasRoles;


class Role extends SnipeModel
{
    protected $presenter = 'App\Presenters\RolesPresenter';
    use Presentable;
    use SoftDeletes;
    protected $dates = [
        'deleted_at',
        'created_at',
        'update_at'

    ];

    // use HasRoles;

    protected $guard_name = "staff";

    protected $guarded = 'id';

    protected $table ='roles';

    protected $rules = array(
        'name'          => 'required|min:2|max:255',
        'company_id'    => 'integer|nullable',
        'project_id'    => 'integer|nullable',
    );

    protected $casts = [
        'company_id'    => 'integer',
        'user_id'       => 'integer',
        'project_id'    => 'integer|nullable',
    

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
    'contractor_id',
    'implementationplan_id',

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
        'due_date',
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
        return $this->hasMany('\App\Models\User', 'role_id');
    }

     // new add by farez 8/2/2021
    //  public function company()
    //  {
    //      return $this->hasMany('\App\Models\Company', 'role_id');
    //  }
     //end add

     public function company()
     {
         return $this->belongsTo('\App\Models\Company', 'company_id');
     }


    //  /**
    //  * Query builder scope to order on company
    //  *
    //  * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
    //  * @param  text                              $order         Order
    //  *
    //  * @return \Illuminate\Database\Query\Builder          Modified query builder
    //  */
    // public function scopeOrderCompany($query, $order)
    // {
    //     return $query->leftJoin('companies as companies', 'roles.company_id', '=', 'companies.id')->select('role.*')
    //         ->orderBy('companies.name', $order);
    // }
}
