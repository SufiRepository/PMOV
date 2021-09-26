<?php

namespace App\Presenters;


/**
 * Class ComponentPresenter
 * @package App\Presenters
 */
class PaymentSchedulePresenter extends Presenter
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
                "field" => "task_name",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('Name'),
                "visible" => false,
                "formatter" => "notesFormatter"
            ], 
          
            [
                "field" => "contractor",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('general.contractors'),
                "visible" => true,
                "formatter" => "contractorsLinkObjFormatter"
            ], 

            // [
            //     "field" => "paymentdate",
            //     "searchable" => true,
            //     "sortable" => true,
            //     "visible" => true,
            //     "title" => trans('Payment Date'),
            //     'formatter' => "notesFormatter"
            // ],  

            [
                "field" => "amount",
                "searchable" => true,
                "sortable" => true,
                "visible" => true,
                "title" => trans('Amount'),
                "footerFormatter" => 'sumFormatter',
            ], 
            [
                "field" => "description",
                "searchable" => true,
                "sortable" => true,
                "visible" => true,
                "title" => trans('Description'),
                "formatter" => "notesFormatter"
            ],
            // [
            //     "field" => "actions",
            //     "searchable" => false,
            //     "sortable" => false,
            //     "switchable" => false,
            //     "title" => trans('table.actions'),
            //     "visible" => true,
            //     "formatter" => "paymentschedulesActionsFormatter",
            // ]
        ];
        return json_encode($layout);
    }

    /**
     * Url to view this item.
     * @return string
     */
    public function viewUrl()
    {
        return route('paymentschedules.show', $this->id);
    }

    /**
     * Generate html link to this items name.
     * @return string
     */
    public function nameUrl()
    {
        return (string) link_to_route('paymentschedules.show', e($this->name), $this->id);
    }


}
