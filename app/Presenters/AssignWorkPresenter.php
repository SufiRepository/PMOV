<?php

namespace App\Presenters;

/**
 * Class   
 * @package App\Presenters
 */
class AssignworkPresenter extends Presenter
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
                "field" => "contractor",
                "searchable" => true,
                "sortable" => true,
                "visible" => true,
                "title" => trans('admin/contractors/table.contractors'),
                "formatter" => "contractorsLinkObjFormatter"
            ],
            [
                "field" => "project",
                "searchable" => true,
                "sortable" => true,
                "visible" => true,
                "title" => trans('admin/assignworks/table.projects'),
                "formatter" => "projectsLinkObjFormatter"
            ],
          
            [
                "field" => "date_submit",
                "searchable" => true,
                "sortable" => true,
                "visible" => true,
                "title" => trans('admin/assignworks/table.date_submit'),
                'formatter' => 'dateDisplayFormatter'
            ], 

            [
                "field" => "project_value",
                "searchable" => true,
                "sortable" => true,
                "visible" => true,
                "title" => trans('general.project_value'),
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
                "field" => "actions",
                "searchable" => false,
                "sortable" => false,
                "switchable" => false,
                "title" => trans('table.actions'),
                "visible" => true,
                "formatter" => "assignworksActionsFormatter",
            ]
    
        ];



        return json_encode($layout);
    }



    /**
     * Link to this licenses Name
     * @return string
     */
    public function nameUrl()
    {
        return (string)link_to_route('assignworks.show', $this->name, $this->id);
    }

    /**
     * Link to this licenses Name
     * @return string
     */
    public function fullName()
    {
        return $this->name;
    }


    /**
     * Link to this licenses serial
     * @return string
     */
    public function serialUrl()
    {
        return (string) link_to('/assignworks/'.$this->id, mb_strimwidth($this->serial, 0, 50, "..."));
    }

    /**
     * Url to view this item.
     * @return string
     */
    public function viewUrl()
    {
        return route('assignworks.show', $this->id);
    }
}
