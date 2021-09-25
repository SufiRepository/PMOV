<?php
namespace App\Models;

use App\Models\Traits\Acceptable;
use App\Models\Traits\Searchable;
use App\Presenters\Presentable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Watson\Validating\ValidatingTrait;
use DB;


/**
 * Model for Teams.
 *
 * @version    v1.0
 */
class Team extends SnipeModel
{
    protected $presenter = 'App\Presenters\TeamPresenter';
    use CompanyableTrait;
    use Loggable, Presentable;
    use SoftDeletes;

    protected $dates = [
        'created_at',
        'updated_at'];

    protected $guarded = 'id';
    protected $table = 'teams';
    protected $casts = [
        'user_id'            => 'integer',
        'project_id'            => 'integer',
        'company_id'         => 'integer',
    ];
    public $timestamps = true;

    use Searchable;

    use Acceptable;
    
    /**
     * The attributes that should be included when searching the model.
     * 
     * @var array
     */
    protected $searchableAttributes = ['name', 'details'];

    /**
     * The relations and their attributes that should be included when searching the model.
     * 
     * @var array
     */
    protected $searchableRelations = [
        'project'     => ['name'],
        'user'        => ['name'],
        'company'     => ['name'],
        
    ];

    /**
    * Team validation rules
    */
    public $rules = array(
        
        'project_id'        => 'integer|nullable',
        'user_id'           => 'exists:users,id|nullable',
        'company_id'        => 'integer|nullable',
       
        //'company_id'        => 'integer|nullable',
        // 'min_amt'           => 'integer|min:0|nullable',
        // 'purchase_cost'     => 'numeric|nullable',
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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        
        'project_id',
        'user_id',
        'company_id'
    ];



 /**
     * This handles the custom field validation for assets
     *
     * @var array
     */
    public function saveTeam(array $params = [])
    {
        $settings = \App\Models\Setting::getSettings();

        // I don't remember why we have this here? Asset tag would always be required, even if auto increment is on...
        $this->rules['user_tag'] = ($settings->auto_increment_assets == '1') ;

        return parent::save($params);
    }


    /**
     * Sets the detailedNameAttribute
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return string
     */
    public function getDetailedNameAttribute()
    {
        if ($this->assignedto) {
            $user_name = $this->assignedto->present()->name();
        } else {
            $user_name = "Unassigned";
        }
        return $this->user_tag . ' - ' . $this->name . ' (' . $user_name . ') ' . ($this->model) ? $this->model->name: '';
    }

     /**
     * Get the next autoincremented asset tag
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @return string | false
     */
    public static function autoincrement_asset()
    {
        $settings = \App\Models\Setting::getSettings();


        if ($settings->auto_increment_assets == '1') {
            $temp_user_tag = \DB::table('teams')
                ->max('asset_tag');

            $user_tag_digits = preg_replace('/\D/', '', $temp_user_tag);
            $user_tag = preg_replace('/^0*/', '', $user_tag_digits);

            if ($settings->zerofill_count > 0) {
                return $settings->auto_increment_prefix.Asset::zerofill($settings->next_auto_tag_base, $settings->zerofill_count);
            }
            return $settings->auto_increment_prefix.$settings->next_auto_tag_base;
        } else {
            return false;
        }
    }

 /**
     * Get the next base number for the auto-incrementer.
     *
     * We'll add the zerofill and prefixes on the fly as we generate the number.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @return int
     */
    public static function nextAutoIncrement($assets)
    {

        $max = 1;

        foreach ($assets as $asset) {
            $results = preg_match ( "/\d+$/" , $asset['user_tag'], $matches);

            if ($results)
            {
                $number = $matches[0];

                if ($number > $max)
                {
                    $max = $number;
                }
            }
        }
        return $max + 1;

    }

       /**
     * Add zerofilling based on Settings
     *
     * We'll add the zerofill and prefixes on the fly as we generate the number.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @return string
     */
    public static function zerofill($num, $zerofill = 3)
    {
        return str_pad($num, $zerofill, '0', STR_PAD_LEFT);
    }

    /**
     * Sets the requestable attribute on the accessory
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @return void
     */
    public function setRequestableAttribute($value)
    {
        if ($value == '') {
            $value = null;
        }
        $this->attributes['requestable'] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
        return;
    }

    /**
     * Establishes the team -> project relationship
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function project()
    {
        return $this->belongsTo('\App\Models\Project', 'project_id');
    }

     /**
     * Establishes the team -> project relationship
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function role()
    {
        return $this->belongsTo('\App\Models\Role', 'role_id');
    }

    /**
     * Establishes the accessory -> users relationship
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */

    public function user()
    {
        return $this->belongsTo('\App\Models\User', 'user_id');
    }

    /**
     * Checks whether or not the team has users
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return int
     */
    public function hasUsers()
    {
        return $this->belongsToMany('\App\Models\User', 'users_teams', 'team_id', 'assigned_to')->count();
    }



    /**
     * Checks for a category-specific EULA, and if that doesn't exist,
     * checks for a settings level EULA
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return string
     */
    public function getEula()
    {

        $Parsedown = new \Parsedown();

        if ($this->category->eula_text) {
            return $Parsedown->text(e($this->category->eula_text));
        } elseif ((Setting::getSettings()->default_eula_text) && ($this->category->use_default_eula=='1')) {
            return $Parsedown->text(e(Setting::getSettings()->default_eula_text));
        }
            return null;
    }


    /**
    * Query builder scope to order on project
    *
    * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
    * @param  text                              $order       Order
    *
    * @return \Illuminate\Database\Query\Builder          Modified query builder
    */
    public function scopeOrderProject($query, $order)
    {
        return $query->leftJoin('projects', 'teams.project_id', '=', 'projects.id')
        ->orderBy('projects.name', $order);
    }


}
