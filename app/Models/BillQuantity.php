<?php
namespace App\Models;

use App\Http\Traits\UniqueUndeletedTrait;
use App\Models\Traits\Searchable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Validating\ValidatingTrait;
use Auth;
use DB;

class BillQuantity extends SnipeModel
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'billquantities';

    protected $rules = array(
        // 'name'                     => 'required|min:1|max:255|unique_undeleted',
        'modelNo'                  => 'required',
        'company_id'               => 'integer|nullable',
        'user_id'                  => 'integer|nullable',
        'project_id'               => 'integer|nullable',

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
        'sale_value',
        'buy_value',
        'company_id',
        'user_id',
        'project_id',
        'serial',
        'type',
    ];



    //Untuk count client ,sekiranya superuser dia akan list all,and untuk admin dia akan count untuk project dia shj
    // public function count_by_company () {

    //     $user = new User;

    //     if (Auth::user()->isSuperUser()) {
    //         return DB::table('clients')
    //                 ->select('clients.*')
    //                 ->where('clients.deleted_at','=',null)
    //                 ->count();
    //     } else {
    //     return DB::table('clients as a')
    //                 ->leftJoin('users as b','a.company_id','=','b.company_id')
    //                 ->where('b.id', Auth::id())
    //                 ->where('a.deleted_at','=',null)
    //                 ->count();
    //     }
    // }
// end client count




     // new add by farez 2/9/2021
     public function company()
     {
         return $this->hasMany('\App\Models\Company', 'client_id');
     }
     //end add

     
     // new add by farez 2/9/2021
     public function user()
     {
         return $this->hasMany('\App\Models\User', 'user_id');
     }
     //end add

     // new add by farez 2/9/2021
     public function project()
     {
         return $this->hasMany('\App\Models\Project', 'project_id');
     }
     //end add




   

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
