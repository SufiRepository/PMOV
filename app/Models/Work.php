<?php
namespace App\Models;

use App\Http\Traits\UniqueUndeletedTrait;
use App\Models\Traits\Searchable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Validating\ValidatingTrait;

class Work extends SnipeModel
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'works';

    protected $rules = array(
        'name'               => 'required|string|min:3|max:255',
        'details'            => 'string|nullable',
        'user_id'            => 'required|exists:users,id',
        'company_id'         => 'integer|nullable',
        'location_id'        => 'exists:locations,id|nullable',
        'client_id'          => 'exists:clients,id|nullable',
        'contractor_id'      => 'exists:contractors,id|nullable',
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
        'company_id',
        'user_id',
        'name',
        'details',
        'costing',
        'due_date',
        'start_date',
        'location_id',
        'client_id',
        'contractor_id',
    ];



   

     // new add by farez 8/2/2021
     public function company()
     {
         return $this->hasMany('\App\Models\Company', 'work_id');
     }
     //end add

    /**
     * Establishes the work -> assets relationship
     *
     * @author farez@mindwave.my
     * @since [v1.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function assets()
    {
        return $this->hasMany('\App\Models\Asset', 'work_id');
    }

    /**
     * Establishes the work -> accessories relationship
     *
     * @author farez@mindwave.com
     * @since [v1.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function accessories()
    {
        return $this->hasMany('\App\Models\Accessory', 'work_id');
    }

    /**
     * Establishes the work -> asset maintenances relationship
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v1.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function asset_maintenances()
    {
        return $this->hasMany('\App\Models\AssetMaintenance', 'work_id');
    }

    /**
     * Return the number of assets by work
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
     * Establishes the work -> license relationship
     *
     * @author farez@mindawve.my
     * @since [v1.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function licenses()
    {
        return $this->hasMany('\App\Models\License', 'work_id');
    }

    /**
     * Return the number of licenses by work
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
     * Add http to the url in works if the user didn't give one
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
}
