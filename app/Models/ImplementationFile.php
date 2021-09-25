<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SnipeModel;
use App\Models\ImplementationPlan;
use App\Models\Traits\Searchable;


class ImplementationFile extends SnipeModel
{
    protected $dates = [
        'deleted_at',
        'updated_at',
    ];

    protected $table ='implementations_files';

    protected $rules = array(
        'name'          => 'required|min:2|max:255',
        'notes'         => 'string|min:2|max:255|nullable',
        'file_path'     => 'string|nullable',
        'implementationplan_id'      => 'integer|nullable',
        'filename'      => 'string|min:2|max:255',

    );

    protected $casts = [
        'implementationplan_id'    => 'integer',
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
        return $this->hasMany('\App\Models\ImplementationPlan', 'implementationplan_id');
    }

}
