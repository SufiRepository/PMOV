<?php
namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\Models\File;
use Gate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class FilesTransformer
{

    public function transformFiles (Collection $files, $total)
    {
        $array = array();

        foreach ($files as $file) {
            $array[] = self::transformFile($file);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformFile (File $file)
    {
        $array = [
            'id'            => (int) $file->id,
            'name'          => e($file->name),
            'file_path'     => e($file->file_path),
            'notes'         => e($file->notes), 
            'filename'      => e($file->filename),
            'file_location' => e($file->file_location),         
            'created_at'    => Helper::getFormattedDateObject($file->created_at, 'datetime'),
            'updated_at'    => Helper::getFormattedDateObject($file->updated_at, 'datetime'),
        ];

        $permissions_array['available_actions'] = [
            
            // 'update' => Gate::allows('update', File::class),
            'delete' => Gate::allows('delete', File::class),
        ];
        $array += $permissions_array;
        return $array;
    }


}
