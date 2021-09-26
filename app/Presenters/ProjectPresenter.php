<?php

namespace App\Presenters;

/**
 * Class LicenPresenter 
 * @package App\Presenters
 */
class ProjectPresenter extends Presenter
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
            //     "visible" => true
            // ], 
            [
                "field" => "name",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/projects/table.project_name'),
                "visible" => true,
                "formatter" => ""
            ],
            

            [
                "field" => "projectnumber",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/projects/table.projectnumber'),
                "visible" => true,
                "switchable" => true,
                "formatter" => ""
            ],
            // [
            //     "field" => "start_date",
            //     "searchable" => true,
            //     "sortable" => true,
            //     "visible" => false,
            //     "switchable" => true,
            //     "title" => trans('admin/projects/table.start_date'),
            //     'formatter' => 'dateDisplayFormatter'
            // ], 

             [
                "field" => "end_date",
                "searchable" => true,
                "sortable" => true,
                "visible" => true,
                "switchable" => true,
                "title" => trans('admin/projects/table.end_date'),
                'formatter' => 'dateDisplayFormatter'
            ],

            [
                "field" => "value",
                "searchable" => true,
                "sortable" => true,
                "visible" => false,
                "switchable" => true,
                "title" => trans('admin/projects/table.project_value'),
                "footerFormatter" => 'sumFormatter',
            ], 

            // [
            //     "field" => "duration",
            //     "searchable" => true,
            //     "sortable" => true,
            //     "visible" => false,
            //     "title" => trans('Duration'),
            //     "footerFormatter" => 'sumDurationFormatter',            
            
            // ],

            //  [
            //     "field" => "details",
            //     "searchable" => true,
            //     "sortable" => true,
            //     "visible" => false,
            //     "title" => trans('general.details'),
            //     "formatter" => "notesFormatter"
            //  ],

            // [
            //     "field" => "company",
            //     "searchable" => true,
            //     "sortable" => true,
            //     "switchable" => true,
            //     "title" => trans('admin/companies/table.title'),
            //     "visible" => false,
            //     "formatter" => "companiesLinkObjFormatter"
            // ], 
            // [
            //     "field" => "typeproject",
            //     "searchable" => true,
            //     "sortable" => true,
            //     "switchable" => true,
            //     "title" => trans('admin/companies/table.typeproject'),
            //     "visible" => false,
            //     "formatter" => "typeprojectsLinkObjFormatter"
            // ], 
            [
                "field" => "client",
                "searchable" => true,
                "sortable" => true,
                "visible" => true,
                "title" => trans('admin/clients/table.clients'),
                "formatter" => "clientsLinkObjFormatter"
            ],


            //   [
            //     "field" => "user",
            //     "searchable" => true,
            //     "sortable" => true,
            //     "switchable" => true,
            //     "title" => trans('general.admin'),
            //     "visible" => false,
            //     "formatter" => "usersLinkObjFormatter"
            // ],

            // [
            //     "field" => "location",
            //     "searchable" => true,
            //     "sortable" => true,
            //     "visible" => false,
            //     "title" => trans('admin/hardware/table.location'),
            //     "formatter" => "deployedLocationFormatter"
            // ],

             [
                "field" => "actions",
                "searchable" => false,
                "sortable" => false,
                "switchable" => false,
                "title" => trans('table.actions'),
                "visible" => true,
                "formatter" => "projectsActionsFormatter",
            ]
    
        ];



        return json_encode($layout);
    }


/**
     * Generate img tag to this items image.
     * @return mixed|string
     */
    public function imageUrl()
    {
        $imagePath = '';
        if ($this->image && !empty($this->image)) {
            $imagePath = $this->image;
            $imageAlt = $this->name;
        } elseif ($this->model && !empty($this->model->image)) {
            $imagePath = $this->model->image;
            $imageAlt = $this->model->name;
        }
        $url = config('app.url');
        if (!empty($imagePath)) {
            $imagePath = '<img src="'.$url.'/uploads/assets/'.$imagePath.' height="50" width="50" alt="'.$imageAlt.'">';
        }
        return $imagePath;
    }

    /**
     * Generate img tag to this items image.
     * @return mixed|string
     */
    public function imageSrc()
    {
        $imagePath = '';
        if ($this->image && !empty($this->image)) {
            $imagePath = $this->image;
        } elseif ($this->model && !empty($this->model->image)) {
            $imagePath = $this->model->image;
        }
        if (!empty($imagePath)) {
            return config('app.url').'/uploads/assets/'.$imagePath;
        }
        return $imagePath;
    }

    /**
     * Link to this licenses Name
     * @return string
     */
    public function nameUrl()
    {
        return (string)link_to_route('projects.show', $this->name, $this->id);
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
        return (string) link_to('/projects/'.$this->id, mb_strimwidth($this->serial, 0, 50, "..."));
    }

    /**
     * Url to view this item.
     * @return string
     */
    public function viewUrl()
    {
        return route('projects.show', $this->id);
    }
}
