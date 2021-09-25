<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SnipeModel;
use App\Models\Task;
Use App\Models\Subtask;
Use App\Models\Project;
use App\Models\Traits\Searchable;


class File extends SnipeModel
{
    protected $dates = [
        'deleted_at',
        'updated_at',
    ];

    protected $table ='files';

    protected $rules = array(
        'name'          => 'required|min:2|max:255|unique_undeleted',
        'notes'         => 'string|min:2|max:255|nullable',
        'file_path'     => 'string|nullable',
        'project_id'    => 'integer|nullable',
        'filename'      => 'string|min:2|max:255',

    );

    protected $casts = [
        'project_id'    => 'integer',
    ];

    // use HasFactory;

    protected $fillable = [
        'name',
        'file_path',
        'notes',
        'filename'
    ];

    use Searchable;

    protected $searchableAttributes = [
        'name',    
    ];

    public function projects()
    {
        return $this->hasMany('\App\Models\Project', 'project_id');
    }

    /**
     * Get uploads for this project files
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function uploads()
    {
        return $this->hasMany('\App\Models\File', 'project_id')
                  ->where('project_id', '=', $project->id)
                  ->orderBy('created_at', 'desc');
                //   ->where('action_type', '=', 'uploaded')
                //   ->whereNotNull('filename')
                  
    }

}
