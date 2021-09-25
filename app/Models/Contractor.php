<?php
namespace App\Models;

use App\Http\Traits\UniqueUndeletedTrait;
use App\Models\Traits\Searchable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Validating\ValidatingTrait;
use Auth;
use DB;

class Contractor extends SnipeModel
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'contractors';

    protected $rules = array(
        'name'              => 'required|min:1|max:255|unique_undeleted',
        'address'           => 'max:50|nullable',
        'address2'          => 'max:50|nullable',
        'city'              => 'max:255|nullable',
        'state'             => 'max:32|nullable',
        'country'           => 'max:3|nullable',
        'fax'               => 'min:7|max:35|nullable',
        'phone'             => 'min:7|max:35|nullable',
        'contact'           => 'max:100|nullable',
        'notes'             => 'max:191|nullable', // Default string length is 191 characters..
        'email'             => 'email|max:150|nullable',
        'zip'               => 'max:10|nullable',
        'url'               => 'sometimes|nullable|string|max:250',
        'company_id'        => 'integer|nullable',
    );

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

    use Searchable;
    
    /**
     * The attributes that should be included when searching the model.
     * 
     * @var array
     */
    protected $searchableAttributes = ['name'];

    /**
     * The relations and their attributes that should be included when searching the model.
     * 
     * @var array
     */
    protected $searchableRelations = [];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'address',
        'address2',
        'city',
        'state',
        'country',
        'zip',
        'phone',
        'fax',
        'email',
        'contact',
        'url',
        'notes',
        'company_id',
    ];


    /**
     * Eager load counts
     *
     * We do this to eager load the "count" of seats from the controller.
     * Otherwise calling "count()" on each model results in n+1.
     *
     * @author farez@mindave.com
     * @since [v4.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function assetsRelation()
    {
        return $this->hasMany(Asset::class)->whereNull('deleted_at')->selectRaw('contractor_id, count(*) as count')->groupBy('contractor_id');
    }

    /**
     * Sets the license seat count attribute
     *
     * @todo I don't see the licenseSeatsRelation here?
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v1.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function getLicenseSeatsCountAttribute()
    {
        if ($this->licenseSeatsRelation->first()) {
            return $this->licenseSeatsRelation->first()->count;
        }

        return 0;
    }

       //Untuk count client ,sekiranya superuser dia akan list all,and untuk admin dia akan count untuk project dia shj
       public function count_by_company () {

        $user = new User;

        if (Auth::user()->isSuperUser()) {
            return DB::table('contractors')
                    ->select('contractors.*')
                    ->where('contractors.deleted_at','=',null)
                    ->count();
        } else {
        return DB::table('contractors as a')
                    ->leftJoin('users as b','a.company_id','=','b.company_id')
                    ->where('b.id', Auth::id())
                    ->where('a.deleted_at','=',null)
                    ->count();
        }
    }
// end client count

     // new add by farez 8/2/2021
     public function company()
     {
         return $this->hasMany('\App\Models\Company', 'contractor_id');
     }
     //end add


     public function assignwork()
     {
         return $this->hasMany('\App\Models\Assignwork', 'contractor_id');
     }

    /**
     * Establishes the contractor -> assets relationship
     *
     * @author farez@mindwave.my
     * @since [v1.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function assets()
    {
        return $this->hasMany('\App\Models\Asset', 'contractor_id');
    }

    /**
     * Establishes the contractor -> accessories relationship
     *
     * @author farez@mindwave.com
     * @since [v1.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function accessories()
    {
        return $this->hasMany('\App\Models\Accessory', 'contractor_id');
    }

    /**
     * Establishes the contractor -> asset maintenances relationship
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v1.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function asset_maintenances()
    {
        return $this->hasMany('\App\Models\AssetMaintenance', 'contractor_id');
    }

    /**
     * Return the number of assets by contractor
     *
     * @author farez@mindwave.my
     * @since [v1.0]
     * @return int
     */
    public function num_assets()
    {
        if ($this->assetsRelation->first()) {
            return $this->assetsRelation->first()->count;
        }

        return 0;
    }

 

    /**
     * Return the number of licenses by contractor
     *
     * @author farez@mindwave.my
     * @since [v1.0]
     * @return int
     */
    public function num_licenses()
    {
        return $this->licenses()->count();
    }

    /**
     * Add http to the url in Contractors if the user didn't give one
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
     * Establishes the contractor -> project relationship
     *
     * @author farez@mindwave.com
     * @since [v2.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function project()
    {
        return $this->belongsTo('\App\Models\Project', 'project_id');
    }


      /**
     * Establishes the contractor -> project relationship
     *
     * @author farez@mindwave.com
     * @since [v2.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function Subtask()
    {
        return $this->belongsTo('\App\Models\Subtask', 'subtask_id');
    }



/**
    * Query builder scope to order on company
    *
    * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
    * @param  text                              $order       Order
    *
    * @return \Illuminate\Database\Query\Builder          Modified query builder
    */
    public function scopeOrderCompany($query, $order)
    {
        return $query->leftJoin('companies as company_sort', 'contractors.company_id', '=', 'company_sort.id')->orderBy('company_sort.name', $order);
    }

}
