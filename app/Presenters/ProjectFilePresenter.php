<?php

namespace App\Presenters;


/**
 * Class ComponentPresenter
 * @package App\Presenters
 */
class ProjectFilePresenter extends Presenter
{

    /**
     * Json Column Layout for bootstrap table
     * @return string
     */
    public static function dataTableLayout()
    {
        $layout = [
            [
                "field" => "id",
                "searchable" => false,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('general.id'),
                "visible" => false
            ],

            [
                "field" => "filename",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/billquantities/table.names'),
                "visible" => true,
                // "formatter" => 'subtasksLinkFormatter',
            ],
 [
                "field" => "file_path",
                "searchable" => true,
                "sortable" => true,
                "title" => "File",
                "visible" => true,
                "formatter" => 'downloadLinkFormatter',
            ],
            [
                "field" => "created_at",
                "searchable" => true,
                "sortable" => true,
                "title" => "Date Uploaded",
                "visible" => true,
                // "formatter" => 'subtasksLinkFormatter',
            ],
            
           

        ];

        return json_encode($layout);
    }

    /**
     * Url to view this item.
     * @return string
     */
    public function viewUrl()
    {
        return route('files.show', $this->id);
    }

    /**
     * Generate html link to this items name.
     * @return string
     */
    public function nameUrl()
    {
        return (string) link_to_route('files.show', e($this->name), $this->id);
    }


}
