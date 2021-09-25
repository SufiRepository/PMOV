<?php
namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\Models\SubtaskFile;
use Gate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class SubtaskFileTransformer
{

    public function transformSubtaskFiles (Collection $subtaskfiles, $total)
    {
        $array = array();

        foreach ($subtaskfiles as $file) {
            $array[] = self::transformSubtaskFile($file);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformSubtaskFile (SubtaskFile $subtaskfile)
    {
        $array = [
            'id'            => (int) $subtaskfile->id,
            'name'          => e($subtaskfile->name),
            'file_path'     => e($subtaskfile->file_path),
            'notes'         => e($subtaskfile->notes),  
            'filename'      => e($subtaskfile->filename),        
            'created_at'    => Helper::getFormattedDateObject($subtaskfile->created_at, 'datetime'),
            'updated_at'    => Helper::getFormattedDateObject($subtaskfile->updated_at, 'datetime'),
        ];

        $permissions_array['available_actions'] = [
            
            'update' => Gate::allows('update', SubtaskFile::class),
            'delete' => Gate::allows('delete', SubtaskFile::class),
        ];
        $array += $permissions_array;
        return $array;
    }


}
