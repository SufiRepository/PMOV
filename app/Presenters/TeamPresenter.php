<?php
namespace App\Presenters;

/**
 * Class TeamPresenter
 * @package App\Presenters
 */
class TeamPresenter extends Presenter
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
                "visible" => false,
            ],
            [
                "field" => "user",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" =>  trans('admin/projects/general.project_members'),
                "visible" => true,
                "formatter" => "usersLinkObjFormatter"
            ],
            [
                "field" => "role",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('Project Role'),
                "visible" => true,
                "formatter" => "rolesLinkObjFormatter"
            ],

            [
                "field" => "project",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('admin/projects/table.title'),
                "visible" => false,
                "formatter" => "projectsLinkObjFormatter"
            ], 
            [
                "field" => "actions",
                "searchable" => false,
                "sortable" => false,
                "switchable" => false,
                "title" => trans('table.actions'),
                "visible" => true,
                "formatter" => "teamsActionsFormatter",
            ]
        ];

        return json_encode($layout);
    }


    /**
     * Pregenerated link to this teams view page.
     * @return string
     */
    public function nameUrl()
    {
        return (string) link_to_route('teams.show', $this->name, $this->id);
    }

    /**
     * Url to view this item.
     * @return string
     */
    public function viewUrl()
    {
        return route('teams.show', $this->id);
    }

    public function name()
    {
        return $this->model->name;
    }
}
