<?php

namespace App\Presenters;


/**
 * Class ComponentPresenter
 * @package App\Presenters
 */
class BillQuantityPresenter extends Presenter
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
                "title" => trans('admin/billquantities/table.description'),
                "visible" => true,
                "formatter" => '',
            ],
            [
                "field" => "brand",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/billquantities/table.brand'),
                "visible" => true,
                "formatter" => '',
            ],

            [
                "field" => "modelNo",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/billquantities/table.modelNo.'),
                "visible" => true,
                // "formatter" => 'billquantitiesLinkFormatter',
            ],

            [
                "field" => "serial",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/billquantities/table.serial_No'),
                "visible" => false,
                "formatter" => '',
            ],
            [
                "field" => "type",
                "searchable" => true,
                "sortable" => true,
                "visible" => true,
                "title" => trans('admin/billquantities/table.categories'),
                "formatter" => "notesFormatter"
             ],
             [
                "field" => "option",
                "searchable" => true,
                "sortable" => true,
                "visible" => true,
                "title" => trans('admin/billquantities/table.type'),
                "formatter" => "notesFormatter"
             ],
             

            [
                "field" => "sale_value",
                "searchable" => true,
                "sortable" => true,
                "visible" => false,
                "title" => trans('general.selling_price'),
                "footerFormatter" => 'sumFormatter',
            ], 

            [
                "field" => "buy_value",
                "searchable" => true,
                "sortable" => true,
                "visible" => false,
                "title" => trans('general.cost_price'),
                "footerFormatter" => 'sumFormatter',
            ], 

            // [
            //     "field" => "net_profit",
            //     "searchable" => true,
            //     "sortable" => true,
            //     "visible" => false,
            //     "title" => trans('general.net_profit'),
            //     "footerFormatter" => 'sumFormatter',
            // ], 
            [
                "field" => "remark",
                "searchable" => true,
                "sortable" => true,
                "visible" => false,
                "title" => trans('admin/billquantities/form.remark'),
                "formatter" => "notesFormatter"
             ],
            [
                "field" => "actions",
                "searchable" => false,
                "sortable" => false,
                "switchable" => false,
                "title" => trans('table.actions'),
                "visible" => true,
                "formatter" => "billquantitiesActionsFormatter",
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
        return route('billquantity.show', $this->id);
    }

    /**
     * Generate html link to this items name.
     * @return string
     */
    public function nameUrl()
    {
        return (string) link_to_route('billquantity.show', e($this->name), $this->id);
    }


}
