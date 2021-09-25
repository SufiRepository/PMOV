<?php

namespace App\Presenters;

/**
 * Class StatusTaskPresenter
 * @package App\Presenters
 */
class StatusTaskPresenter extends Presenter
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
            ],[
                "field" => "name",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('admin/statustasks/table.name'),
                "visible" => true,
                "formatter" => 'statustasksLinkFormatter',
            ],[
                "field" => "updated_at",
                "searchable" => false,
                "sortable" => true,
                "visible" => false,
                "title" => trans('general.updated_at'),
                "formatter" => 'createdAtFormatter',
            ],[
                "field" => "created_at",
                "searchable" => false,
                "sortable" => true,
                "visible" => false,
                "title" => trans('general.created_at'),
                "formatter" => 'createdAtFormatter',
            ],[
                "field" => "actions",
                "searchable" => false,
                "sortable" => false,
                "switchable" => false,
                "title" => trans('table.actions'),
                "visible" => true,
                "formatter" => "statustasksActionsFormatter",
            ]
        ];

        return json_encode($layout);
    }


    /**
     * Link to this statustasks name
     * @return string
     */
    public function nameUrl()
    {
        return (string) link_to_route('statustasks.show', $this->name, $this->id);
    }

    /**
     * Url to view this item.
     * @return string
     */
    public function viewUrl()
    {
        return route('statustasks.show', $this->id);
    }
}
