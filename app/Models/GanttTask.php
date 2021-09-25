<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class GanttTask extends Model
{
    
    protected $appends = ["open"];

     // We set these as protected dates so that they will be easily accessible via Carbon
    protected $dates = [
        'created_at',
        'updated_at',
        'start_date'
    ];

    public $timestamps = true;

    protected $table = 'task';
 
    public function getOpenAttribute(){
        return true;
    }

    protected $rules = array(
        'text'               => 'required|string|min:3|max:255',
        'duration'           => 'integer|nullable',
        'project_id'         => 'integer|nullable',
     );

     protected $fillable = [
        'project_id',
        'text',
        'duration',
        'progress',
        'start_date',
        'parent',

    ];

    public function projects()
    {
        return $this->belongsTo('\App\Models\Project', 'project_id');
    }
}
