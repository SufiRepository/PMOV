<?php

namespace App\Presenters;


/**
 * Class ComponentPresenter
 * @package App\Presenters
 */
class PaymentTaskPresenter extends Presenter
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
                "visible" => true
            ],
            [
                "field" => "name",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('general.name'),
                "visible" => true,
                "formatter" => 'paymenttasksLinkFormatter',
            ],
            [
                "field" => "costing",
                "searchable" => true,
                "sortable" => true,
                "visible" => true,
                "title" => trans('general.costing'),
                "footerFormatter" => 'sumFormatter',
            ], 
            [
                "field" => "details",
                "searchable" => true,
                "sortable" => true,
                "visible" => true,
                "title" => trans('general.details'),
                "formatter" => "notesFormatter"
            ],
            
            [
                "field" => "file_path",
                "searchable" => true,
                "sortable" => true,
                "title" => "File",
                "visible" => true,
                "formatter" => 'purchaseodertaskdownloadLinkFormatter',
            ],

            [
                "field" => "actions",
                "searchable" => false,
                "sortable" => false,
                "switchable" => false,
                "title" => trans('table.actions'),
                "visible" => true,
                "formatter" => "paymenttasksActionsFormatter",
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
        return route('paymenttasks.show', $this->id);
    }

    /**
     * Generate html link to this items name.
     * @return string
     */
    public function nameUrl()
    {
        return (string) link_to_route('paymenttasks.show', e($this->name), $this->id);
    }


}
