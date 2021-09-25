<?php

namespace App\Presenters;


/**
 * Class ComponentPresenter
 * @package App\Presenters
 */
class ImplementationFilePresenter extends Presenter
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
                "field" => "name",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/implementationplans/form.filenames'),
                "visible" => true,
                // "formatter" => 'subtasksLinkFormatter',
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
                "field" => "file_path",
                "searchable" => true,
                "sortable" => true,
                "title" => "File",
                "visible" => true,
                "formatter" => 'implementationdownloadLinkFormatter',
            ],

            [
                "field" => "created_at",
                "searchable" => true,
                "sortable" => true,
                "visible" => true,
                "title" => trans('Uploaded Date/Time'),
                'formatter' => 'dateDisplayFormatter'
            ],
            
            [
                "field" => "actions",
                "searchable" => false,
                "sortable" => false,
                "switchable" => false,
                "title" => trans('table.actions'),
                "visible" => true,
                "formatter" => "projectuploadActionsFormatter",
            ]

        ];

        return json_encode($layout);
    }

    /**
     * Url to view this item.
     * @return string
     */
    public function viewUrl()
    {
        return route('taskuploads.show', $this->id);
    }

    /**
     * Generate html link to this items name.
     * @return string
     */
    public function nameUrl()
    {
        return (string) link_to_route('taskuploads.show', e($this->name), $this->id);
    }


}
