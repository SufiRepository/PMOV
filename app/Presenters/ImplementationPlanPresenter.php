<?php

namespace App\Presenters;


/**
 * Class ComponentPresenter
 * @package App\Presenters
 */
class ImplementationPlanPresenter extends Presenter
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
                "title" => trans('admin/projects/general.implemntationplans'),
                "visible" => true,
                "formatter" => 'implementationplansLinkFormatter',
            ],
            // [
            //     "field" => "contractor",
            //     "searchable" => true,
            //     "sortable" => true,
            //     "title" => trans('general.contractors'),
            //     "visible" => true,
            //     "formatter" => "contractorsLinkObjFormatter"
            // ], 

            // [
            //     "field" => "supplier",
            //     "searchable" => true,
            //     "sortable" => true,
            //     "title" => trans('general.supplier'),
            //     "visible" => true,
            //     "formatter" => "suppliersLinkObjFormatter"
            // ], 

           
            
            // [
            //     "field" => "status",
            //     "searchable" => true,
            //     "sortable" => true,
            //     "title" => trans('admin/hardware/table.status'),
            //     "visible" => true,
            //     "formatter" => "statustasksLinkObjFormatter"
            // ], 
            
            [
                "field" => "contract_start_date",
                "searchable" => true,
                "sortable" => true,
                "visible" => true,
                "title" => trans('admin/implementationplans/form.start_date'),

                'formatter' => 'dateDisplayFormatter'
            ], 
            [
                "field" => "contract_end_date",
                "searchable" => true,
                "sortable" => true,
                "visible" => true,
                "title" => trans('admin/implementationplans/form.end_date'),
                'formatter' => 'dateDisplayFormatter'
            ],  

            [
                "field" => "contract_duration",
                "searchable" => true,
                "sortable" => true,
                "visible" => true,
                "title" => trans('admin/implementationplans/form.duration'),
                "footerFormatter" => 'sumDurationFormatter',            

             ],

           [
                "field" => "actual_start_date",
                "searchable" => true,
                "sortable" => false,
                "visible" => false,
                "title" => trans('general.actual_start_date'),
                'formatter' => 'dateDisplayFormatter'
            ], 

            [
                "field" => "actual_end_date",
                "searchable" => true,
                "sortable" => true,
                "visible" => false,
                "title" => trans('general.actual_end_date'),
                'formatter' => 'dateDisplayFormatter'
            ],  
           
            
            [
                "field" => "actual_duration",
                "searchable" => true,
                "sortable" => true,
                "visible" => false,
                "title" => trans('general.actual_duration'),
                // "formatter" => "notesFormatter"
                "footerFormatter" => 'sumDurationFormatter',            

             ],

            [
                "field" => "details",
                "searchable" => true,
                "sortable" => true,
                "visible" => false,
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
                "formatter" => "implementationplansActionsFormatter",
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
        return route('implementationplans.show', $this->id);
    }

    /**
     * Generate html link to this items name.
     * @return string
     */
    public function nameUrl()
    {
        return (string) link_to_route('implementationplans.show', e($this->name), $this->id);
    }


}
