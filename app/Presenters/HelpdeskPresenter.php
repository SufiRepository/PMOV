<?php

namespace App\Presenters;

/**
 * Class HelpdeskPresenter
 * @package App\Presenters
 */
class HelpdeskPresenter extends Presenter
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
                "title" => trans('admin/helpdesks/table.name'),
                "visible" => true,
                "formatter" => "notesFormatter"
            ],
            // [
            //     "field" => "user",
            //     "searchable" => true,
            //     "sortable" => true,
            //     "switchable" => true,
            //     "title" => trans('Issuer'),
            //     "visible" => false,
            //     "formatter" => "usersLinkObjFormatter"
            // ],

            [
                "field" => "client_name",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('Client'),
                "visible" => true,
                "formatter" => "notesFormatter"
            ],

            [
                "field" => "client_phone",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('Client phone'),
                "visible" => true,
                "formatter" => "notesFormatter"
            ],

            [
                "field" => "priority",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('Priority'),
                "visible" => true,
                "formatter" => "notesFormatter"
            ],

            [
                "field" => "status",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('Status'),
                "visible" => true,
                "formatter" => "notesFormatter"
            ],

            [
                "field" => "due_date",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('Due date'),
                "visible" => true,
                "formatter" => "notesFormatter"
            ],

            // [
            //     "field" => "engineer",
            //     "searchable" => true,
            //     "sortable" => true,
            //     "title" => trans('Engineer'),
            //     "visible" => true,
            //     "formatter" => "notesFormatter"
            // ],

            // [
            //     "field" => "solution",
            //     "searchable" => true,
            //     "sortable" => true,
            //     "title" => trans('Solution'),
            //     "visible" => true,
            //     "formatter" => "notesFormatter"
            // ],

            // [
            //     "field" => "solution_status",
            //     "searchable" => true,
            //     "sortable" => true,
            //     "title" => trans('Solution_status'),
            //     "visible" => true,
            //     "formatter" => "notesFormatter"
            // ],

            // [
            //     "field" => "responded_date",
            //     "searchable" => true,
            //     "sortable" => true,
            //     "title" => trans('Responded date'),
            //     "visible" => true,
            //     "formatter" => "notesFormatter"
            // ],
            // [
            //     "field" => "user",
            //     "searchable" => true,
            //     "sortable" => true,
            //     "title" => "Issuer",
            //     "visible" => true,
            //     "formatter" => "usersLinkObjFormatter"
            // ],

            // [
            //     "field" => "location_id",
            //     "searchable" => true,
            //     "sortable" => true,
            //     "switchable" => true,
            //     "title" => trans('admin/helpdesks/table.location_id'),
            //     "visible" => true,
            //     "formatter" => "locationsLinkObjFormatter"
            // ],

            // [
            //     "field" => "company",
            //     "searchable" => true,
            //     "sortable" => true,
            //     "switchable" => true,
            //     "title" => trans('admin/companies/table.title'),
            //     "visible" => true,
            //     "formatter" => "companiesLinkObjFormatter"
            // ], 

            [
                "field" => "description",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('Description'),
                "visible" => true,
                "formatter" => "notesFormatter"
            ],
            [
                "field" => "actions",
                "searchable" => false,
                "sortable" => false,
                "switchable" => false,
                "title" => trans('table.actions'),
                "visible" => true,
                "formatter" => "helpdesksActionsFormatter",
            ]
        ];

        return json_encode($layout);
    }

    /**
     * Link to this helpdesk name
     * @return string
     */
    public function nameUrl()
    {
        return (string) link_to_route('helpdesks.show', $this->name, $this->id);
    }

    /**
     * Url to view this item.
     * @return string
     */
    public function viewUrl()
    {
        return route('helpdesks.show', $this->id);
    }
}
