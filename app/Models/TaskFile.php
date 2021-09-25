<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SnipeModel;
use App\Models\Task;
use App\Models\Traits\Searchable;


class TaskFile extends SnipeModel
{
    protected $dates = [
        'deleted_at',
        'updated_at',
    ];

    protected $table ='tasks_files';

    protected $rules = array(
        'name'          => 'required|min:2|max:255|unique_undeleted',
        'notes'         => 'string|min:2|max:255|nullable',
        'file_path'     => 'string|nullable',
        'task_id'       => 'integer|nullable',
        'filename'      => 'string|min:2|max:255',

    );

    protected $casts = [
        'task_id'    => 'integer',
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

    public function implementationplan()
    {
        return $this->hasMany('\App\Models\Task', 'task_id');
    }

}
