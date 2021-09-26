<?php
namespace App\Models;

use App\Models\Traits\Searchable;
use App\Presenters\Presentable;
use Carbon\Carbon;
use DB;
use App\Models\Typeproject;
use App\Models\Task;
use App\Models\Team;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Watson\Validating\ValidatingTrait;

use App\Http\Controllers\MailsController;

class Project extends SnipeModel
{
    protected $presenter = 'App\Presenters\ProjectPresenter';

    const LOCATION = 'location';
    
    use SoftDeletes;
    use CompanyableTrait;
    use Loggable, Presentable;
    protected $injectUniqueIdentifier = true;
    use ValidatingTrait;

    // We set these as protected dates so that they will be easily accessible via Carbon
    protected $dates = [
        'created_at',
        'deleted_at',
        'end_date',
        'start_date',
        'finis_date',

       ];


    public $timestamps = true;

    protected $guarded = 'id';
    protected $table = 'projects';

    protected $casts = [
        'company_id'         => 'integer',
        'user_id'            => 'integer',
        'location_id'        => 'integer',
        'client_id'          => 'integer',
        'contractor_id'      => 'integer',
        'typeproject_id'     => 'integer',

    ];

    protected $rules = array(
        'name'               => 'required|string|min:3|max:255',
        
        'details'            => 'string|nullable',
        'user_id'            => 'required|exists:users,id',
        'company_id'         => 'integer|nullable',
        'location_id'        => 'exists:locations,id|nullable',
        'client_id'          => 'exists:clients,id|nullable',
        'contractor_id'      => 'exists:contractors,id|nullable',
        'typeproject_id'     => 'exists:typeproject,id|nullable',

        // 'filename'           => 'required|min:2|max:255|unique_undeleted',
        // 'path'               => 'string|nullable',

    );

   /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
   
        'name',
        'projectnumber',
        'details',
        'costing',
        'value',
        'end_date',
        'finish_date',
        'start_date',
        'duration',
        'location_id',
        'client_id',
        'contractor_id',   
        'company_id',
        'user_id',
        'typeproject_id',

        // 'name',
        // 'file_path'

    ];

    use Searchable;
    
    /**
     * The attributes that should be included when searching the model.
     * 
     * @var array
     */
    protected $searchableAttributes = [
        'name', 
        'projectnumber',
        'details',
        'costing',
        'value',
        'end_date',
        'finish_date',
        'start_date',
        'location_id',
        'client_id',
        'contractor_id',
        'typeproject_id',

    ];

    /**
     * The relations and their attributes that should be included when searching the model.
     * 
     * @var array
     */
    protected $searchableRelations = [
      'company'          => ['name'],
      'user'             => ['name'],
      'project'          => ['name'],
      'location'         => ['name'],
      'client'           => ['name'],
      'contractor'       => ['name'],
      'typeproject'      => ['name'],
    ];



    public static function getIdForCurrentProject($id)
    {
       
            $current_project = Auth::project();

            
                if ($current_project->project_id != null) {
                    return $current_project->project_id;
                } else {
                    return static::getIdFromInput($unescaped_input);
                }
    }

    /**
     * Sets expiration date attribute
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v1.0]
     * @return mixed
     */
    public function setEndDateAttribute($value)
    {

        if ($value == '' || $value == '0000-00-00') {
            $value = null;
        } else {
            $value = (new Carbon($value))->toDateString();
        }
        $this->attributes['end_date'] = $value;
    }


   

    /**
     * Establishes the project -> action logs relationship
     *
     * @author farez@mindawave.my
     * @since [v2.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function assetlog()
    {
        return $this->hasMany('\App\Models\Actionlog', 'item_id')
            ->where('item_type', '=', Project::class)
            ->orderBy('created_at', 'desc');
    }

    /**
     * Establishes the Project -> action logs -> uploads relationship
     *
     * @author farez@mindawave.my
     * @since [v2.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function uploads()
    {
        return $this->hasMany('\App\Models\Actionlog', 'item_id')
            ->where('item_type', '=', Project::class)
            ->where('action_type', '=', 'uploaded')
            ->whereNotNull('filename')
            ->orderBy('created_at', 'desc');
    }

     /**
     * Establishes the project -> status relationship
     *
     * @author farez@mindwave.my
     * @since [v1.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function projectstatus()
    {
        return $this->belongsTo('\App\Models\Statuslabel', 'status_id');
    }



    // /**
    //  * Establishes the project -> admin user relationship
    //  *
    //  * @author farez@mindwave.my
    //  * @since [v2.0]
    //  * @return \Illuminate\Database\Eloquent\Relations\Relation
    //  */
    // public function adminuser()
    // {
    //     return $this->belongsTo('\App\Models\User', 'user_id');
    // }




    /**
     * Returns due date project
     *
     * @todo should refactor. I don't like get() in model methods
     *
     * @author farez@mindawave.my
     * @since [v1.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public static function getEndDateProject($days = 60)
    {

        return Project::whereNotNull('end_date')
        ->whereNull('deleted_at')
        ->whereRaw(DB::raw('DATE_SUB(`end_date`,INTERVAL '.$days.' DAY) <= DATE(NOW()) '))
        ->where('end_date', '>', date("Y-m-d"))
        ->orderBy('end_date', 'ASC')
        ->get();

    }
    public function isDeletable()
    {
        return (Gate::allows('delete', $this))
            && ($this->assets()->count()  === 0)
            && ($this->licenses()->count() === 0)
            && ($this->consumables()->count() === 0)
            && ($this->accessories()->count() === 0);
    }


    public function count_by_user() {

        $user = new User;

        // if (Auth::user()->isSuperUser()) {
        //     return DB::table('assets')
        //             ->select('assets.*')
        //             ->where('assets.deleted_at','=',null)
        //             ->count();
        // } else {
        return DB::table('projects as a')
                    // ->leftJoin('users as b','a.company_id','=','b.company_id')
                    ->where('user_id', Auth::id())
                    ->where('a.deleted_at','=',null)
                    ->count();
        
    }


    public function assets()
    {
        return $this->hasMany(Asset::class, 'project_id');
    }

    public function licenses()
    {
        return $this->hasMany(License::class, 'project_id');
    }

    public function team()
    {
        return $this->hasMany(Team::class, 'team_id');
    }
    
    public function accessories()
    {
        return $this->hasMany(Accessory::class, 'project_id');
    }

    public function consumables()
    {
        return $this->hasMany(Consumable::class, 'project_id');
    }

    public function components()
    {
        return $this->hasMany(Component::class, 'project_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'project_id');
    }

 /**
     * Establishes the project -> company relationship
     *
     * @author farez@mindwave.my
     * @since [v2.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function company()
    {
        return $this->belongsTo('\App\Models\Company', 'company_id');
    }
    // new add 27/5/21

     /**
     * Establishes the project -> location relationship
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v2.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function location()
    {
        return $this->belongsTo('\App\Models\Location', 'location_id');
    }

    //new add 8/6 by farez 


    /**
     * Establishes the project -> client relationship
     *
     * @author farez@mindwave.com
     * @since [v2.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function client()
    {
        return $this->belongsTo('\App\Models\Client', 'client_id');
    }

    /**
     * Establishes the project -> client relationship
     *
     * @author farez@mindwave.com
     * @since [v2.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function typeproject()
    {
        return $this->belongsTo('\App\Models\Typeproject', 'typeproject_id');
    }



    // end add


    // 14/6/2021

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

    public function implementationplan()
    {
        return $this->belongsTo('\App\Models\Implementationplan', 'implementationplan_id');
    }


    // end add
     /**
     * Establishes the project -> company relationship
     *
     * @author farez@mindwave.my
     * @since [v2.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */

     
    public function user()
    {
        return $this->belongsTo('\App\Models\User', 'user_id');
    }

    
    /**
     * Add http to the url in project2s if the user didn't give one
     *
     * @todo this should be handled via validation, no?
     *
     * @author farez@mindwave.my
     * @since [v3.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function addhttp($url)
    {
        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
            $url = "http://" . $url;
        }
        return $url;
    }

     /**
     * Returns expiring project
     *
     * @todo should refactor. I don't like get() in model methods
     *
     * @author Farez
     * @since [v1.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public static function getExpiringProject($days = 7)
    {

        return Project::whereNotNull('end_date')
        ->whereNull('deleted_at')
        ->whereRaw(DB::raw('DATE_SUB(`end_date`,INTERVAL '.$days.' DAY) <= DATE(NOW()) '))
        ->where('end_date', '>', date("Y-m-d"))
        ->orderBy('end_date', 'ASC')
        ->get();

    }

    public function getProjectTeam() {
        return $this->hasMany('\App\Models\Team');
    }

}


