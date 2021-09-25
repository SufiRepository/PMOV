<?php
namespace App\Models;

use App\Http\Traits\UniqueUndeletedTrait;
use App\Models\Traits\Searchable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Validating\ValidatingTrait;

class Assignwork extends SnipeModel
{
    use SoftDeletes;
    protected $dates = [
                        'created_at',
                        'updated_at',
                        'deleted_at',
                        'last_audit_date',
                        'date_submit'
                        ];
    protected $table = 'assignworks';

    protected $rules = array(
    
        'company_id'        => 'integer|nullable',
        // 'project_id'        => 'integer|nulable',
        'contrctor_id'      => 'integer|nulable',
        // 'user_id'           => 'integer|nulable'
        'date_submit' => 'date|nullable',
        'last_audit_date' => 'date|nullable',
        
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
    // protected $searchableAttributes = ['name'];

    /**
     * The relations and their attributes that should be included when searching the model.
     * 
     * @var array
     */
    protected $searchableRelations = [];

      /**
     * The attributes that should be included when searching the model.
     * 
     * @var array
     */
    protected $searchableAttributes = [
      
        'project_value',
        'contractor_id',
        'project_id',
        'company_id'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'project_id',
        'user_id',
        'contractor_id',
        'date_submit',
        'project_value',
        'details'
    ];


    //**
    //  * Eager load counts
    //  *
    //  * We do this to eager load the "count" of seats from the controller.
    //  * Otherwise calling "count()" on each model results in n+1.
    //  *
    //  * @author farez@mindave.com
    //  * @since [v4.0]
    //  * @return \Illuminate\Database\Eloquent\Relations\Relation
    //  */
    // public function assetsRelation()
    // {
    //     return $this->hasMany(Asset::class)->whereNull('deleted_at')->selectRaw('assignwork_id, count(*) as count')->groupBy('assignwork_id');
    // }

   

     // new add by farez 8/2/2021
    //  public function company()
    //  {
    //      return $this->hasMany('\App\Models\Company', 'assignwork_id');
    //  }

    //  public function project()
    //  {
    //      return $this->hasMany('\App\Models\Project', 'assignwork_id');
    //  }

    //  public function contrctor()
    //  {
    //      return $this->hasMany('\App\Models\Contarctor', 'assignwork_id');
    //  }

     //end add




    /**
     * Establishes the Assignwork -> company relationship
     *
     * @author farez@mindwave.com
     * @since [v2.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function company()
    {
        return $this->belongsTo('\App\Models\Company', 'company_id');
    }

       /**
     * Establishes the Assignwork -> project relationship
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
     * Establishes the Assignwork -> contractor relationship
     *
     * @author farez@mindwave.com
     * @since [v2.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function contractor()
    {
        return $this->belongsTo('\App\Models\Contractor', 'contractor_id');
    }


    // using for audit

    /**
     * Query builder scope for assignwork that are due for auditing, based on the assignwork.next_audit_date
     * and settings.audit_warning_days.
     *
     * This is/will be used in the artisan command snipeit:upcoming-audits and also
     * for an upcoming API call for retrieving a report on assignwork that will need to be audited.
     *
     * Due for audit soon:
     * next_audit_date greater than or equal to now (must be in the future)
     * and (next_audit_date - threshold days) <= now ()
     *
     * Example:
     * next_audit_date = May 4, 2025
     * threshold for alerts = 30 days
     * now = May 4, 2019
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since v4.6.16
     * @param Setting $settings
     *
     * @return \Illuminate\Database\Query\Builder          Modified query builder
     */

    public function scopeDueForAudit($query, $settings)
    {
        $interval = $settings->audit_warning_days ?? 0;

        return $query->whereNotNull('assignworks.next_audit_date')
            ->where('assignworks.next_audit_date', '>=', Carbon::now())
            ->whereRaw("DATE_SUB(assignworks.next_audit_date, INTERVAL $interval DAY) <= '".Carbon::now()."'");
    }

/**
     * Query builder scope for assignworks that are OVERDUE for auditing, based on the assignworks.next_audit_date
     * and settings.audit_warning_days. It checks to see if assignworks.next audit_date is before now
     *
     * This is/will be used in the artisan command snipeit:upcoming-audits and also
     * for an upcoming API call for retrieving a report on overdue assignworks.
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since v4.6.16
     * @param Setting $settings
     *
     * @return \Illuminate\Database\Query\Builder          Modified query builder
     */

    public function scopeOverdueForAudit($query)
    {
        return $query->whereNotNull('assignworks.next_audit_date')
            ->where('assignworks.next_audit_date', '<', Carbon::now());
    }

    /**
     * Query builder scope for assingworks that are due for auditing OR overdue, based on the assingworks.next_audit_date
     * and settings.audit_warning_days.
     *
     * This is/will be used in the artisan command snipeit:upcoming-audits and also
     * for an upcoming API call for retrieving a report on assingworks that will need to be audited.
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since v4.6.16
     * @param Setting $settings
     *
     * @return \Illuminate\Database\Query\Builder          Modified query builder
     */

    public function scopeDueOrOverdueForAudit($query, $settings)
    {
        $interval = $settings->audit_warning_days ?? 0;

        return $query->whereNotNull('assingworks.next_audit_date')
            ->whereRaw("DATE_SUB(".DB::getTablePrefix()."assingworks.next_audit_date, INTERVAL $interval DAY) <= '".Carbon::now()."'");
    }
}
