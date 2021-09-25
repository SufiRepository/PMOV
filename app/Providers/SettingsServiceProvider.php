<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Setting;

/**
 * This service provider handles sharing the snipeSettings variable, and sets
 * some common upload path and image urls.
 *
 * PHP version 5.5.9
 * @version    v3.0
 */

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Custom email array validation
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return void
     */
    public function boot()
    {


        // Share common setting variables with all views.
        view()->composer('*', function ($view) {
            $view->with('snipeSettings', Setting::getSettings());
        });


        /**
         * Set some common variables so that they're globally available.
         * The paths should always be public (versus private uploads)
         */



        // Model paths and URLs

        \App::singleton('assets_upload_path', function(){
            return 'assets/';
        });

        \App::singleton('accessories_upload_path', function() {
            return 'public/uploads/accessories/';
        });

        \App::singleton('models_upload_path', function(){
            return 'models/';
        });

        \App::singleton('models_upload_url', function(){
            return 'models/';
        });

        // Categories
        \App::singleton('categories_upload_path', function(){
            return 'categories/';
        });

        \App::singleton('categories_upload_url', function(){
            return 'categories/';
        });

        // Locations
        \App::singleton('locations_upload_path', function(){
            return 'locations/';
        });

        \App::singleton('locations_upload_url', function(){
            return 'locations/';
        });

        // Users
        \App::singleton('users_upload_path', function(){
            return 'avatars/';
        });

        \App::singleton('users_upload_url', function(){
            return 'users/';
        });

        // Manufacturers
        \App::singleton('manufacturers_upload_path', function(){
            return 'manufacturers/';
        });

        \App::singleton('manufacturers_upload_url', function(){
            return 'manufacturers/';
        });

        // Suppliers
        \App::singleton('suppliers_upload_path', function(){
            return 'suppliers/';
        });

        \App::singleton('suppliers_upload_url', function(){
            return 'suppliers/';
        });

         // Typeprojects
         \App::singleton('typeprojects_upload_path', function(){
            return 'typeprojects/';
        });

        \App::singleton('typeprojects_upload_url', function(){
            return 'typeprojects/';
        });

         // task
         \App::singleton('tasks_upload_path', function(){
            return 'tasks/';
        });

        \App::singleton('tasks_upload_url', function(){
            return 'tasks/';
        });

           // role
           \App::singleton('roles_upload_path', function(){
            return 'roles/';
        });

        \App::singleton('tasks_upload_url', function(){
            return 'tasks/';
        });

          // implementationplan
          \App::singleton('implementationplans_upload_path', function(){
            return 'implementationplans/';
        });

        \App::singleton('implementationplans_upload_url', function(){
            return 'implementationplans/';
        });



        // subtask
        \App::singleton('subtasks_upload_path', function(){
            return 'subtasks/';
        });

        \App::singleton('subtasks_upload_url', function(){
            return 'subtasks/';
        });

        
        // PaymentSchedule
        \App::singleton('paymentschedules_upload_path', function(){
            return 'paymentschedules/';
        });

        \App::singleton('paymentschedules_upload_url', function(){
            return 'paymentschedules';
        });

        // paymenttasks
        \App::singleton('paymenttasks_upload_path', function(){
            return 'paymenttasks/';
        });

        \App::singleton('paymenttasks_upload_url', function(){
            return 'paymenttasks';
        });

        // paymentsubtasks
        \App::singleton('paymentsubtasks_upload_path', function(){
            return 'paymentsubtasks/';
        });

        \App::singleton('paymentsubtasks_upload_url', function(){
            return 'paymentsubtasks';
        });

        // ProjectFile
        \App::singleton('projectuploads_upload_path', function(){
            return 'projectuploads/';
        });

        \App::singleton('projectuploads_upload_url', function(){
            return 'projectuploads';
        });

         // ImplementationFile
         \App::singleton('implementationuploads_upload_path', function(){
            return 'implementationuploads/';
        });

        \App::singleton('implementationuploads_upload_url', function(){
            return 'implementationuploads';
        });

          // TaskFile
          \App::singleton('taskuploads_upload_path', function(){
            return 'taskuploads/';
        });

        \App::singleton('taskuploads_upload_url', function(){
            return 'taskuploads';
        });

        // SubtaskFile
        \App::singleton('subtaskuploads_upload_path', function(){
            return 'subtaskuploads/';
        });

        \App::singleton('subtaskuploads_upload_url', function(){
            return 'subtaskuploads';
        });

        // Billing
        \App::singleton('billings_upload_path', function(){
            return 'billings/';
        });

        \App::singleton('billings_upload_url', function(){
            return 'billings';
        });

        // add by farez 3/6/2021
        
        // clients
        \App::singleton('clients_upload_path', function(){
            return 'clients/';
        });

        \App::singleton('clients_upload_url', function(){
            return 'clients/';
        });
        
        // end add

        // add by farez 15/6/2021
        
        // contractor
        \App::singleton('contractors_upload_path', function(){
            return 'contractors/';
        });

        \App::singleton('contractors_upload_url', function(){
            return 'contractors/';
        });
        
        // end add

           // add by farez 6/6/2021
        
        // statustask
        \App::singleton('statustasks_upload_path', function(){
            return 'statustasks/';
        });

        \App::singleton('statustasks_upload_url', function(){
            return 'statustasks/';
        });
        
        // end add

        // Departments
        \App::singleton('departments_upload_path', function(){
            return 'departments/';
        });

        \App::singleton('departments_upload_url', function(){
            return 'departments/';
        });

        // Company paths and URLs
        \App::singleton('companies_upload_path', function(){
            return 'companies/';
        });

        \App::singleton('companies_upload_url', function(){
            return 'companies/';
        });

        // add by farez 17/5

         // project paths and URLs
         \App::singleton('projects_upload_path', function(){
            return 'projects/';
        });

        \App::singleton('projects_upload_url', function(){
            return 'projects/';
        });

        // end add

        // add by farez 21/6

         // Assignwork paths and URLs
         \App::singleton('assignworks_upload_path', function(){
            return 'assignworks/';
        });

        \App::singleton('assignworks_upload_url', function(){
            return 'assignworks/';
        });

        // end add

        // Accessories paths and URLs
        \App::singleton('accessories_upload_path', function(){
            return 'accessories/';
        });

        \App::singleton('accessories_upload_url', function(){
            return 'accessories/';
        });

        // Consumables paths and URLs
        \App::singleton('consumables_upload_path', function(){
            return 'consumables/';
        });

        \App::singleton('consumables_upload_url', function(){
            return 'consumables/';
        });


        // Components paths and URLs
        \App::singleton('components_upload_path', function(){
            return 'components/';
        });

        \App::singleton('components_upload_url', function(){
            return 'components/';
        });



        // Set the monetary locale to the configured locale to make helper::parseFloat work.
        setlocale(LC_MONETARY, config('app.locale'));
        setlocale(LC_NUMERIC, config('app.locale'));

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
