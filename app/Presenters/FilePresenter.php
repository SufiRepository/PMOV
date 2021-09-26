<?php

namespace App\Presenters;


/**
 * Class ComponentPresenter
 * @package App\Presenters
 */
class FilePresenter extends Presenter
{

    /**
     * Json Column Layout for bootstrap table
     * @return string
     */
    public static function dataTableLayout()
    {
        $layout = [
            // [
            //     "field" => "id",
            //     "searchable" => false,
            //     "sortable" => true,
            //     "switchable" => true,
            //     "title" => trans('general.id'),
            //     "visible" => false
            // ],

            [
                "field" => "name",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('Filename'),
                "visible" => true,
                // "formatter" => 'subtasksLinkFormatter',
            ],
            [
                "field" => "file_location",
                "searchable" => true,
                "sortable" => true,
                "visible" => true,
                "title" => trans('File Location'),
                'formatter' => 'notesFormatter'
            ],
            [
                "field" => "file_path",
                "searchable" => true,
                "sortable" => true,
                "title" => "Download",
                "visible" => true,
                "formatter" => 'projectdownloadLinkFormatter',
            ],
            [
                "field" => "notes",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('Notes'),
                "visible" => true,
                "formatter" => 'notesFormatter',
            ],
             
            [
                "field" => "actions",
                "searchable" => false,
                "sortable" => false,
                "switchable" => false,
                "title" => trans('table.actions'),
                "visible" => true,
                "formatter" => "projectuploadActionsFormatter",
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
        return route('projectuploads.show', $this->id);
    }

    /**
     * Generate html link to this items name.
     * @return string
     */
    public function nameUrl()
    {
        return (string) link_to_route('projectuploads.show', e($this->name), $this->id);
    }


}
