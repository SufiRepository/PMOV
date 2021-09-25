<?php
namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\Models\TaskFile;
use Gate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class TaskFilesTransformer
{

    public function transformTaskFiles (Collection $taskfiles, $total)
    {
        $array = array();

        foreach ($taskfiles as $file) {
            $array[] = self::transformTaskFile($file);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformTaskFile (TaskFile $taskfile)
    {
        $array = [
            'id'            => (int) $taskfile->id,
            'name'          => e($taskfile->name),
            'file_path'     => e($taskfile->file_path),
            'notes'         => e($taskfile->notes),
            'filename'      => e($taskfile->filename),          
            'created_at'    => Helper::getFormattedDateObject($taskfile->created_at, 'datetime'),
            'updated_at'    => Helper::getFormattedDateObject($taskfile->updated_at, 'datetime'),
        ];

        $permissions_array['available_actions'] = [
            
            'update' => Gate::allows('update', TaskFile::class),
            'delete' => Gate::allows('delete', TaskFile::class),
        ];
        $array += $permissions_array;
        return $array;
    }


}
