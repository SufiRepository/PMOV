<?php
namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\Models\ImplementationFile;
use Gate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class ImplementationFilesTransformer
{

    public function transformImplementationFiles (Collection $implementationfiles, $total)
    {
        $array = array();

        foreach ($implementationfiles as $implementationfile) {
            $array[] = self::transformImplementationFile($implementationfile);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformImplementationFile (ImplementationFile $implementationfile)
    {
        $array = [
            'id'            => (int) $implementationfile->id,
            'name'          => e($implementationfile->name),
            'file_path'     => e($implementationfile->file_path),
            'notes'         => e($implementationfile->notes),
            'filename'      => e($implementationfile->filename),          
            'created_at'    => Helper::getFormattedDateObject($implementationfile->created_at, 'datetime'),
            'updated_at'    => Helper::getFormattedDateObject($implementationfile->updated_at, 'datetime'),
        ];

        $permissions_array['available_actions'] = [
            
            'update' => Gate::allows('update', ImplementationFile::class),
            'delete' => Gate::allows('delete', ImplementationFile::class),
        ];
        $array += $permissions_array;
        return $array;
    }


}
