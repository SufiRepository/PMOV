<?php

namespace App\Presenters;


/**
 * Class ComponentPresenter
 * @package App\Presenters
 */
class TaskPresenter extends Presenter
{

    /**
     * Json Column Layout for bootstrap table
     * @return string
     */
    public static function dataTableLayout()
    {
        $layout = [
            [
                "field" => "name",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('general.tasks'),
                "visible" => true,
                "formatter" => '',
            ],
            [
                "field" => "numsubtask",
                "searchable" => true,
                "sortable" => true,
                "visible" => true,
                "title" => trans('admin/tasks/table.numsubtask'),
                "formatter" => "tasksLinkFormatter"
            ],
            
            [
                "field" => "contract_start_date",
                "searchable" => true,
                "sortable" => true,
                "visible" => false,
                "title" => trans('admin/tasks/form.start_date'),
                'formatter' => 'dateDisplayFormatter'
            ],  


            [
                "field" => "contract_end_date",
                "searchable" => true,
                "sortable" => true,
                "visible" => false,
                "title" => trans('admin/tasks/form.end_date'),
                'formatter' => 'dateDisplayFormatter'
            ],   
            [
                "field" => "contract_duration",
                "searchable" => true,
                "sortable" => true,
                "visible" => false,
                "title" => trans('admin/tasks/form.duration'),
                // "formatter" => "notesFormatter"
                "footerFormatter" => 'sumDurationFormatter',            

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
                "title" => trans('admin/tasks/table.duration'),
                // "formatter" => "notesFormatter"
                "footerFormatter" => 'sumDurationFormatter',            

            ],
            [
                "field" => "priority",
                "searchable" => true,
                "sortable" => true,
                "visible" => true,
                "title" => trans('admin/tasks/table.priority'),
                "formatter" => "notesFormatter"
            ],

            [
                "field" => "statustask",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/hardware/table.status'),
                "visible" => true,
                // "formatter" => "statustasksLinkObjFormatter"
                "formatter" => "notesFormatter"
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
                "field" => "user",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('general.admin'),
                "visible" => false,
                "formatter" => "usersLinkObjFormatter"
            ],


            [
                "field" => "teammember",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('Project Member'),
                "visible" => false,
                "formatter" => "usersLinkObjFormatter"
            ],
            // [
            //     "field" => "manager",
            //     "searchable" => true,
            //     "sortable" => true,
            //     "switchable" => true,
            //     "title" => trans('Persone Inchrage'),
            //     "visible" => false,
            //     "formatter" => "usersLinkObjFormatter"
            // ],

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
            
            // [
            //     "field" => "paymenttask",
            //     "searchable" => true,
            //     "sortable" => true,
            //     "title" => trans('general.payments'),
            //     "visible" => false,
            //     "formatter" => "paymenttasksLinkObjFormatter"
            // ], 
            
           
           

            [
                "field" => "type",
                "searchable" => true,
                "sortable" => true,
                "visible" => false,
                "title" => trans('admin/tasks/table.payment/billing'),
                "formatter" => "notesFormatter"
            ],

           

            [
                "field" => "typetask",
                "searchable" => true,
                "sortable" => true,
                "visible" => false,
                "title" => trans('Milestone'),
                "formatter" => "notesFormatter"
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
                "formatter" => "tasksActionsFormatter",
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
        return route('tasks.show', $this->id);
    }

    /**
     * Generate html link to this items name.
     * @return string
     */
    public function nameUrl()
    {
        return (string) link_to_route('tasks.show', e($this->name), $this->id);
    }


}
