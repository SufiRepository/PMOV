<?php
namespace App\Presenters;

/**
 * Class AccessoryPresenter
 * @package App\Presenters
 */
class AccessoryPresenter extends Presenter
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
                "field" => "image",
                "searchable" => false,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('admin/hardware/table.image'),
                "visible" => true,
                "formatter" => "imageFormatter"
            ], 
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
            //     "field" => "project",
            //     "searchable" => true,
            //     "sortable" => true,
            //     "switchable" => true,
            //     "title" => trans('admin/projects/table.title'),
            //     "visible" => false,
            //     "formatter" => "projectsLinkObjFormatter"
            // ], 

            [
                "field" => "name",
                "searchable" => true,
                "sortable" => true,
                "visible" => true,
                "title" => trans('admin/accessories/general.accessory_name'),
                // "formatter" => "accessoriesLinkFormatter"
            ], 
            
            [
                "field" => "serial",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/accessories/table.serial_No') ,
                // "formatter" => "accessoriesLinkFormatter"
            ],

            [
                "field" => "model_number",
                "searchable" => true,
                "sortable" => true,
                "visible" => true,
                "title" => trans('admin/models/table.modelnumber'),
                // "formatter" => "accessoriesLinkFormatter"
            ], 
            [
                "field" => "category",
                "searchable" => true,
                "sortable" => true,
                "visible" => false,
                "title" => trans('admin/accessories/general.accessory_category'),
                "formatter" => "categoriesLinkObjFormatter"
            ], 

            
            [
                "field" => "manufacturer",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('general.manufacturer'),
                "formatter" => "manufacturersLinkObjFormatter",
            ], [
                "field" => "supplier",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('general.supplier'),
                "visible" => false,
                "formatter" => "suppliersLinkObjFormatter"
            ], [
                "field" => "location",
                "searchable" => true,
                "sortable" => true,
                "visible" => false,
                "title" => trans('general.location'),
                "formatter" => "locationsLinkObjFormatter",
            ], [
                "field" => "qty",
                "searchable" => false,
                "sortable" => false,
                "visible" => true,
                "title" => trans('admin/accessories/general.total'),
            ],  [
                "field" => "min_qty",
                "searchable" => false,
                "sortable" => true,
                "visible" => false,
                "title" => trans('general.min_amt'),
            ], [
                "field" => "remaining_qty",
                "searchable" => false,
                "sortable" => false,
                "visible" => false,
                "title" => trans('admin/accessories/general.remaining'),
            ], [
                "field" => "purchase_date",
                "searchable" => true,
                "sortable" => true,
                "visible" => false,
                "title" => trans('general.purchase_date'),
                "formatter" => "dateDisplayFormatter"
            ], [
                "field" => "purchase_cost",
                "searchable" => true,
                "sortable" => true,
                "visible" => false,
                "title" => trans('general.purchase_cost'),
                "footerFormatter" => 'sumFormatter',
            ], [
                "field" => "order_number",
                "searchable" => true,
                "sortable" => true,
                "visible" => false,
                "title" => trans('general.order_number'),
            ],[
                "field" => "change",
                "searchable" => false,
                "sortable" => false,
                "visible" => true,
                "title" => trans('admin/licenses/form.assign'),
                "formatter" => "accessoriesInOutFormatter",
            ], [
                "field" => "actions",
                "searchable" => false,
                "sortable" => false,
                "switchable" => false,
                "visible" => true,
                "title" => trans('table.actions'),
                "formatter" => "accessoriesActionsFormatter",
            ]
        ];

        return json_encode($layout);
    }


    /**
     * Pregenerated link to this accessories view page.
     * @return string
     */
    public function nameUrl()
    {
        return (string) link_to_route('accessories.show', $this->name, $this->id);
    }

    /**
     * Url to view this item.
     * @return string
     */
    public function viewUrl()
    {
        return route('accessories.show', $this->id);
    }

    public function name()
    {
        return $this->model->name;
    }
}
