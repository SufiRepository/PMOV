<?php

namespace App\Presenters;


/**
 * Class ComponentPresenter
 * @package App\Presenters
 */
class SubtaskPresenter extends Presenter
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
                "title" => trans('Subtask'),
                "visible" => true,
                // "formatter" => 'subtasksLinkFormatter',
            ],
           
            // [
            //     "field" => "paymentsubtask",
            //     "searchable" => true,
            //     "sortable" => true,
            //     "title" => trans('general.amount'),
            //     "visible" => false,
            //     "formatter" => "paymentsubtaskLinkObjFormatter"
            // ], 
          
            [
                "field" => "contract_start_date",
                "searchable" => true,
                "sortable" => true,
                "visible" => false,
                "title" => trans('admin/subtasks/form.start_date'),
                'formatter' => 'dateDisplayFormatter'
            ],  
            [
                "field" => "contract_end_date",
                "searchable" => true,
                "sortable" => true,
                "visible" => true,
                "title" => trans('admin/subtasks/form.end_date'),
                'formatter' => 'dateDisplayFormatter'
            ],

            [
                "field" => "contract_duration",
                "searchable" => true,
                "sortable" => true,
                "visible" => false,
                "title" => trans('admin/subtasks/form.duration'),
                // "formatter" => "notesFormatter"
                "footerFormatter" => 'sumDurationFormatter',            

            ],
            [
                "field" => "priority",
                "searchable" => true,
                "sortable" => true,
                "visible" => true,
                "title" =>  trans('admin/subtasks/form.priority'),
                "formatter" => "notesFormatter"
            ],

            [
                "field" => "status",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/hardware/table.status'),
                "visible" => true,
                // "formatter" => "statustasksLinkObjFormatter"
            ], 


            [
                "field" => "contractor",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('general.contractors'),
                "visible" => false,
                "formatter" => "contractorsLinkObjFormatter"
            ], 
            [
                "field" => "supplier",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('general.suppliers'),
                "visible" => false,
                "formatter" => "suppliersLinkObjFormatter"
            ], 

            [
                "field" => "amount_task",
                "searchable" => true,
                "sortable" => true,
                "visible" => false,
                "title" => trans('admin/tasks/table.amount'),
                "footerFormatter" => 'sumFormatter',
            ], 

            [
                "field" => "type",
                "searchable" => true,
                "sortable" => true,
                "visible" => false,
                "title" => trans('admin/tasks/table.payment/billing'),
                "formatter" => "notesFormatter"
            ],
            
            [
                "field" => "actual_start_date",
                "searchable" => true,
                "sortable" => true,
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
                "title" => trans('admin/subtasks/table.duration'),
                // "formatter" => "notesFormatter"
                "footerFormatter" => 'sumDurationFormatter',            
            ],
           
            [
                "field" => "details",
                "searchable" => true,
                "sortable" => false,
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
                "formatter" => "subtasksActionsFormatter",
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
        return route('subtasks.show', $this->id);
    }

    /**
     * Generate html link to this items name.
     * @return string
     */
    public function nameUrl()
    {
        return (string) link_to_route('subtasks.show', e($this->name), $this->id);
    }


}
