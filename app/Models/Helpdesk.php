<?php
namespace App\Models;

use App\Models\Traits\Searchable;
use App\Presenters\Presentable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Gate;
use Watson\Validating\ValidatingTrait;

class Helpdesk extends SnipeModel
{
    protected $presenter = 'App\Presenters\HelpdeskPresenter';
    use Presentable;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'helpdesks';

    // Declare the rules for the form validation
    protected $rules = array(
        'name'           => 'required|min:2|max:255',
        'issue'          => 'issue|nullable',
        'location_id'    => 'exists:locations,id|nullable',
        
    );

    protected $hidden = ['user_id'];

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
        'name',
        'issue',
        'location_id',
        // 'project_id',
        'description',
        
    ];

    use Searchable;

    /**
     * The attributes that should be included when searching the model.
     *
     * @var array
     */
    protected $searchableAttributes = ['name', 'created_at'];

    /**
     * The relations and their attributes that should be included when searching the model.
     *
     * @var array
     */
    protected $searchableRelations = [
        'issue'              => ['name'],
        'description'        => ['name'],
        'location'           => ['name'],
        'model'              => ['name', 'model_number'],
        'model.category'     => ['name'],
        'model.manufacturer' => ['name'],
    ];


    public function isDeletable()
    {
        return (Gate::allows('delete', $this));
            // && ($this->assets()->count()  === 0)
            // && ($this->licenses()->count() === 0)
            // && ($this->consumables()->count() === 0)
            // && ($this->accessories()->count() === 0));
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

    public function project()
    {
        return $this->belongsTo('\App\Models\Project', 'project_id');
    }

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
    public function user()
    {
        return $this->belongsTo('\App\Models\User', 'user_id');
    }

}
