<?php



Route::group(['middleware' => 'auth'], function () {
    /*
    * Companies
    */
    Route::resource('companies', 'CompaniesController', [
        'parameters' => ['company' => 'company_id']
    ]);

    
  /*
    * sub Companies
    */
    // Route::resource('sub_companies', 'Sub_CompaniesController', [
    //     'parameters' => ['sub_company' => 'sub_company_id']
    // ]);

   
   
  /*
    * test register
    */

    // Route::resource('registers', 'RegistersController', [
    //     'parameters' => ['register' => 'user_id']
    // ]);

    /*
    * Helpdesk
    */

    Route::group([ 'prefix' => 'helpdesks', 'middleware' => ['auth'] ], function () {

        Route::get('{helpdesks_id}/restore', [ 'as' => 'restore/helpdesk', 'uses' => 'HelpdesksController@restore']);
        Route::get('{createtask', [ 'as' => 'helpdeskcreatetask', 'uses' => 'HelpdesksController@createTask']);
        Route::post('{createtaskload', [ 'as' => 'helpdeskcreatetaskload', 'uses' => 'HelpdesksController@storeTask']);
    
    });

    Route::get('issues/create/{id}',  'HelpdesksController@create')->name('createIssue');

    Route::resource('helpdesks', 'helpdesksController', [
        'parameters' => ['helpdesk' => 'helpdesks_id']
    ]);

    
    /*
    * Categories
    */
    Route::resource('categories', 'CategoriesController', [
        'parameters' => ['category' => 'category_id']
    ]);

    /*
    * Locations
    */
    Route::resource('locations', 'LocationsController', [
        'parameters' => ['location' => 'location_id']
    ]);

    /*
    * Project File Upload
    */
    Route::resource('projectuploads', 'ProjectUploadController', [
        'parameters' => ['projectupload' => 'projectupload_id']
    ]);

    /*
    * Task File Upload
    */
    Route::resource('taskuploads', 'TasksUploadController', [
        'parameters' => ['taskupload' => 'taskupload_id']
    ]);

    /*
    * Subtask File Upload
    */
    Route::resource('subtaskuploads', 'SubtasksUploadController', [
        'parameters' => ['subtaskupload' => 'subtaskupload_id']
    ]);

    /*
    * Implementation File Upload
    */
    Route::resource('implementationuploads', 'ImplementationsUploadController', [
        'parameters' => ['implementationupload' => 'implementationupload_id']
    ]);

    /*
    * Manufacturers
    */

    Route::group([ 'prefix' => 'manufacturers', 'middleware' => ['auth'] ], function () {

        Route::get('{manufacturers_id}/restore', [ 'as' => 'restore/manufacturer', 'uses' => 'ManufacturersController@restore']);
    });

    Route::resource('manufacturers', 'ManufacturersController', [
        'parameters' => ['manufacturer' => 'manufacturers_id']
    ]);

    /*
    * Project
    */

    Route::group([ 'prefix' => 'projects', 'middleware' => ['auth'] ], function () {

        Route::get('{projects_id}/restore', [ 'as' => 'restore/project', 'uses' => 'ProjectsController@restore']);
        Route::get('{projects_id}/tasklist', [ 'as' => 'tasklist/project', 'uses' => 'TasksController@index'] );
        // Route::get('{projects_id}/gantt', [ 'as' =>  'gantt/project', 'uses' => 'GanttController@get']);
        Route::get('gantt/{id}', [ 'as' => 'ganttproject', 'uses' => 'ProjectsController@getView'] );
        // Route::get('{taskid}/task', ['as' => 'tasksreroute', 'uses' => 'TasksController@show']);

        Route::get('{projectid}/project', ['as' => 'projectsreroute', 'uses' => 'ProjectsController@show']);

    });

    Route::resource('projects', 'ProjectsController', [
        'parameters' => ['project' => 'projects_id']
    ]);

     /*
    
    * works
    */

    Route::resource('works', 'WorksController', [
        'parameters' => ['work' => 'work_id']
    ]);

    // end add    


    // 2/6/2021 new add by farez 
      /*
    * clients
    */

    Route::resource('clients', 'ClientsController', [
        'parameters' => ['client' => 'client_id']
    ]);

    // end add    

    // 2/9/2021 new add by farez 
      /*
    * bill qualitities
    */

    Route::resource('billquantities', 'BillQuantitiesController', [
        'parameters' => ['billquantity' => 'billquantity_id']
    ]);
    Route::get('billquantities/create/{id}',  'BillQuantitiesController@create')->name('testbillquantities');


    // end add    


      // 15/6/2021 new add by farez 
      /*
    * Contractor
    */

    Route::resource('contractors', 'ContractorsController', [
        'parameters' => ['contractor' => 'contractor_id']
    ]);

    Route::get('/contractors/{id}/addproject', 'ContractorsController@addproject')->name('contractors.addproject');



    // team
    Route::resource('teams', 'TeamsController', [
        'parameters' => ['team' => 'team_id']
    ]);

    //role

    Route::resource('roles', 'RolesController', [ 'parameters' => ['role' => 'role_id'] ]);


    //end roles
  // 21/6/2021 new add by farez 
      /*
    * Assign work
    */

    Route::resource('assignworks', 'AssignworksController', [
        'parameters' => ['assignwork' => 'assignwork_id']
    ]);

    // Route::get('/contractors/{id}/addproject', 'ContractorsController@addproject')->name('contractors.addproject');



    // end add    

    /*
    * Suppliers
    */
    Route::resource('suppliers', 'SuppliersController', [
        'parameters' => ['supplier' => 'supplier_id']
    ]);

      /*
    * Taskprojects
    */
    Route::resource('typeprojects', 'TypeprojectsController', [
        'parameters' => ['typeproject' => 'typeproject_id']
    ]);

    /*
    * paymentschedule
    */

    Route::resource('paymentschedules', 'PaymentschedulesController', [
        'parameters' => ['paymentschedule' => 'paymentschedules_id']
    ]);
    Route::group([ 'prefix' => 'paymentschedules', 'middleware' => ['auth'] ], function () {

        Route::get('view/{id}', ['as' => 'openpaymentbilling', 'uses' => 'PaymentschedulesController@getView']);
        Route::get('newpayment/{id}', ['as' => 'newpayment', 'uses' => 'PaymentschedulesController@getPayment']);
        Route::get('viewpayment/{id}', ['as' => 'viewpayment', 'uses' => 'PaymentschedulesController@viewPayment']);
        Route::get('newpaymentsub/{id}', ['as' => 'newpaymentsub', 'uses' => 'PaymentschedulesController@getPaymentSub']);
        Route::get('viewbilling/{id}', ['as' => 'viewbilling', 'uses' => 'BillingsController@viewBilling']);

        Route::get('createbilling/{id}', [ 'as' => 'createbilling', 'uses' => 'PaymentSchedulesController@createBilling']);
        Route::get('createpayment/{id}', [ 'as' => 'createpayment', 'uses' => 'PaymentSchedulesController@createPayment']);
        Route::post('{createpaymentstore', [ 'as' => 'createpaymentstore', 'uses' => 'PaymentSchedulesController@storePayment']);

    });


      /*
    * billing
    */
    Route::resource('billings', 'BillingsController', [
        'parameters' => ['billing' => 'billings_id']
    ]);

    Route::group([ 'prefix' => 'billings', 'middleware' => ['auth'] ], function () {

        Route::get('newbilling/{id}', ['as' => 'newbilling', 'uses' => 'BillingsController@getCreate']);
        Route::get('newbillingsub/{id}', ['as' => 'newbillingsub', 'uses' => 'BillingsController@getCreateSub']);
        Route::get('viewbilling/{id}', ['as' => 'viewbilling', 'uses' => 'BillingsController@viewBilling']);
        Route::post('{createbillingstore', [ 'as' => 'createbillingstore', 'uses' => 'BillingsController@storeBilling']);

    });

     /*
    * subtasks
    */

    // Route::group([ 'prefix' => 'subtasks', 'middleware' => ['auth'] ], function () {

    //     // Route::get('{projects_id}/restore', [ 'as' => 'restore/project', 'uses' => 'ProjectsController@restore']);
    //     // Route::get('{tasks_id}/tasklist', [ 'as' => 'tasklist/project', 'uses' => 'TasksController@index'] );
    //     // Route::get('{/taskid}', ['as' => 'tasksreroute', 'uses' => 'TasksController@show']);
    //     Route::get('{subtaskid}/subtask', ['as' => 'tasksreroute', 'uses' => 'TasksController@show']);
    // });
    
    Route::group([ 'prefix' => 'subtasks', 'middleware' => ['auth'] ], function () {

        // Route::get('{projects_id}/restore', [ 'as' => 'restore/project', 'uses' => 'ProjectsController@restore']);
        // Route::get('{tasks_id}/tasklist', [ 'as' => 'tasklist/project', 'uses' => 'TasksController@index'] );
        // Route::get('{/taskid}', ['as' => 'tasksreroute', 'uses' => 'TasksController@show']);
        Route::get('{subtaskid}/subtask', ['as' => 'subtasksreroute', 'uses' => 'SubtasksController@show']);
    });

    Route::get('subtasks/create/{id}',  'SubtasksController@create')->name('testsubtask');

    Route::resource('subtasks', 'SubtasksController', [
        'parameters' => ['subtask' => 'subtask_id']
    ]);

    // 6/7/2021 new add by farez 
      /*
    * statustasks
    */

    Route::resource('statustasks', 'StatusTasksController', [
        'parameters' => ['statustask' => 'statustask_id']
    ]);


    /*
    * Task
    */
    Route::group([ 'prefix' => 'tasks', 'middleware' => ['auth'] ], function () {

        // Route::get('{projects_id}/restore', [ 'as' => 'restore/project', 'uses' => 'ProjectsController@restore']);
        // Route::get('{tasks_id}/tasklist', [ 'as' => 'tasklist/project', 'uses' => 'TasksController@index'] );
        // Route::get('{/taskid}', ['as' => 'tasksreroute', 'uses' => 'TasksController@show']);
        Route::get('{taskid}/task', ['as' => 'tasksreroute', 'uses' => 'TasksController@show']);
    });

    Route::get('tasks/create/{id}',  'TasksController@create')->name('testtask');

    Route::resource('tasks', 'TasksController', [
        'parameters' => ['task' => 'task_id']
    ]);
    // end


        /*
    * Implementationplan
    */
    Route::group([ 'prefix' => 'implementationplans', 'middleware' => ['auth'] ], function () {

        // Route::get('{projects_id}/restore', [ 'as' => 'restore/project', 'uses' => 'ProjectsController@restore']);
        // Route::get('{tasks_id}/tasklist', [ 'as' => 'tasklist/project', 'uses' => 'TasksController@index'] );
        // Route::get('{/taskid}', ['as' => 'tasksreroute', 'uses' => 'TasksController@show']);
        Route::get('{implementationplanid}/implementationplan', ['as' => 'impreroute', 'uses' => 'ImplementationPlansController@show']);
    });

    Route::get('implementationplans/create/{id}',  'ImplementationPlansController@create')->name('testimplementation');

    Route::resource('implementationplans', 'ImplementationPlansController', [
        'parameters' => ['implementationplan' => 'implementationplan_id']
    ]);
    // end


    /*
    * Depreciations
     */
     Route::resource('depreciations', 'DepreciationsController', [
         'parameters' => ['depreciation' => 'depreciation_id']
     ]);

     /*
     * Status Labels
      */
      Route::resource('statuslabels', 'StatuslabelsController', [
          'parameters' => ['statuslabel' => 'statuslabel_id']
      ]);

    //   new add by farez 14/6/2021

       /*
     * Status activities
      */
      Route::resource('statusactivities', 'StatusActivitiesController', [
        'parameters' => ['statusactivity' => 'statusactivity_id']
    ]);

    // end add

    /*
    * Departments
    */
    Route::resource('departments', 'DepartmentsController', [
        'parameters' => ['department' => 'department_id']
    ]);


});


/*
|
|--------------------------------------------------------------------------
| Re-Usable Modal Dialog routes.
|--------------------------------------------------------------------------
|
| Routes for various modal dialogs to interstitially create various things
| 
*/

Route::group(['middleware' => 'auth','prefix' => 'modals'], function () {
    Route::get('{type}/{itemId?}',['as' => 'modal.show', 'uses' => 'ModalController@show']);
});

/*
|--------------------------------------------------------------------------
| Log Routes
|--------------------------------------------------------------------------
|
| Register all the admin routes.
|
*/

Route::group(['middleware' => 'auth'], function () {

    Route::get(
        'display-sig/{filename}',
        [
            'as' => 'log.signature.view',
            'uses' => 'ActionlogController@displaySig' ]
    );


});



/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Register all the admin routes.
|
*/



Route::group([ 'prefix' => 'admin','middleware' => ['auth', 'authorize:superuser']], function () {

    Route::get('settings', ['as' => 'settings.general.index','uses' => 'SettingsController@getSettings' ]);
    Route::post('settings', ['as' => 'settings.general.save','uses' => 'SettingsController@postSettings' ]);


    Route::get('branding', ['as' => 'settings.branding.index','uses' => 'SettingsController@getBranding' ]);
    Route::post('branding', ['as' => 'settings.branding.save','uses' => 'SettingsController@postBranding' ]);

    Route::get('security', ['as' => 'settings.security.index','uses' => 'SettingsController@getSecurity' ]);
    Route::post('security', ['as' => 'settings.security.save','uses' => 'SettingsController@postSecurity' ]);

    Route::get('groups', ['as' => 'settings.groups.index','uses' => 'GroupsController@index' ]);

    Route::get('localization', ['as' => 'settings.localization.index','uses' => 'SettingsController@getLocalization' ]);
    Route::post('localization', ['as' => 'settings.localization.save','uses' => 'SettingsController@postLocalization' ]);

    Route::get('notifications', ['as' => 'settings.alerts.index','uses' => 'SettingsController@getAlerts' ]);
    Route::post('notifications', ['as' => 'settings.alerts.save','uses' => 'SettingsController@postAlerts' ]);

    Route::get('email', ['as' => 'settings.email.index','uses' => 'EmailSettingController@create' ]);
    Route::post('email', ['as' => 'settings.email.save','uses' => 'EmailSettingController@store' ]);

    Route::get('slack', ['as' => 'settings.slack.index','uses' => 'SettingsController@getSlack' ]);
    Route::post('slack', ['as' => 'settings.slack.save','uses' => 'SettingsController@postSlack' ]);

    Route::get('asset_tags', ['as' => 'settings.asset_tags.index','uses' => 'SettingsController@getAssetTags' ]);
    Route::post('asset_tags', ['as' => 'settings.asset_tags.save','uses' => 'SettingsController@postAssetTags' ]);

    Route::get('barcodes', ['as' => 'settings.barcodes.index','uses' => 'SettingsController@getBarcodes' ]);
    Route::post('barcodes', ['as' => 'settings.barcodes.save','uses' => 'SettingsController@postBarcodes' ]);

    Route::get('labels', ['as' => 'settings.labels.index','uses' => 'SettingsController@getLabels' ]);
    Route::post('labels', ['as' => 'settings.labels.save','uses' => 'SettingsController@postLabels' ]);

    Route::get('ldap', ['as' => 'settings.ldap.index','uses' => 'SettingsController@getLdapSettings' ]);
    Route::post('ldap', ['as' => 'settings.ldap.save','uses' => 'SettingsController@postLdapSettings' ]);

    Route::get('phpinfo', ['as' => 'settings.phpinfo.index','uses' => 'SettingsController@getPhpInfo' ]);


    Route::get('oauth', [ 'as' => 'settings.oauth.index', 'uses' => 'SettingsController@api' ]);

    Route::get('purge', ['as' => 'settings.purge.index', 'uses' => 'SettingsController@getPurge']);
    Route::post('purge', ['as' => 'settings.purge.save', 'uses' => 'SettingsController@postPurge']);

    Route::get('login-attempts', ['as' => 'settings.logins.index','uses' => 'SettingsController@getLoginAttempts' ]);

    # Backups
    Route::group([ 'prefix' => 'backups', 'middleware' => 'auth' ], function () {


        Route::get('download/{filename}', [
            'as' => 'settings.backups.download',
            'uses' => 'SettingsController@downloadFile' ]);

        Route::delete('delete/{filename}', [
            'as' => 'settings.backups.destroy',
            'uses' => 'SettingsController@deleteFile' ]);

        Route::post('/', [
            'as' => 'settings.backups.create',
            'uses' => 'SettingsController@postBackups'
        ]);

        Route::get('/', [ 'as' => 'settings.backups.index', 'uses' => 'SettingsController@getBackups' ]);

    });



    Route::resource('groups', 'GroupsController', [
        'middleware' => ['auth'],
        'parameters' => ['group' => 'group_id']
    ]);

    Route::get('/', ['as' => 'settings.index', 'uses' => 'SettingsController@index' ]);

    //Added by Fikri

    // Route::get('email', ['as' => 'settings.email.index','uses' => 'SettingsController@getEmail' ]);
    // Route::post('settings', ['as' => 'settings.general.save','uses' => 'SettingsController@postSettings' ]);


});

/*
|--------------------------------------------------------------------------
| Importer Routes
|--------------------------------------------------------------------------
|
|
|
*/
Route::group([ 'prefix' => 'import', 'middleware' => ['auth']], function () {
        Route::get('/', [
                'as' => 'imports.index',
                'uses' => 'ImportsController@index'
        ]);
});


/*
|--------------------------------------------------------------------------
| Account Routes
|--------------------------------------------------------------------------
|
|
|
*/
Route::group([ 'prefix' => 'account', 'middleware' => ['auth']], function () {

    # Profile
    Route::get('profile', [ 'as' => 'profile', 'uses' => 'ProfileController@getIndex' ]);
    Route::post('profile', 'ProfileController@postIndex');

    Route::get('menu', [ 'as' => 'account.menuprefs', 'uses' => 'ProfileController@getMenuState' ]);

    Route::get('password', [ 'as' => 'account.password.index', 'uses' => 'ProfileController@password' ]);
    Route::post('password', [ 'uses' => 'ProfileController@passwordSave' ]);

    Route::get('api', [ 'as' => 'user.api', 'uses' => 'ProfileController@api' ]);

    # View Assets
    Route::get('view-assets', [ 'as' => 'view-assets', 'uses' => 'ViewAssetsController@getIndex' ]);

    Route::get('requested', [ 'as' => 'account.requested', 'uses' => 'ViewAssetsController@getRequestedAssets' ]);

    # Accept Asset
    Route::get(
        'accept-asset/{logID}',
        [ 'as' => 'account/accept-assets', 'uses' => 'ViewAssetsController@getAcceptAsset' ]
    );

    # Profile
    Route::get(
        'requestable-assets',
        [ 'as' => 'requestable-assets', 'uses' => 'ViewAssetsController@getRequestableIndex' ]
    );
    Route::get(
        'request-asset/{assetId}',
        [ 'as' => 'account/request-asset', 'uses' => 'ViewAssetsController@getRequestAsset' ]
    );

    Route::post(
        'request/{itemType}/{itemId}',
        [ 'as' => 'account/request-item', 'uses' => 'ViewAssetsController@getRequestItem']
    );

    # Account Dashboard
    Route::get('/', [ 'as' => 'account', 'uses' => 'ViewAssetsController@getIndex' ]);


    Route::get('accept', 'Account\AcceptanceController@index')
        ->name('account.accept');
        
    Route::get('accept/{id}', 'Account\AcceptanceController@create')
        ->name('account.accept.item');

    Route::post('accept/{id}', 'Account\AcceptanceController@store');        

});


Route::group(['middleware' => ['auth']], function () {

    Route::get('reports/audit', [
        'as' => 'reports.audit',
        'uses' => 'ReportsController@audit'
    ]);

    Route::get(
        'reports/depreciation',
        [ 'as' => 'reports/depreciation', 'uses' => 'ReportsController@getDeprecationReport' ]
    );
    Route::get(
        'reports/export/depreciation',
        [ 'as' => 'reports/export/depreciation', 'uses' => 'ReportsController@exportDeprecationReport' ]
    );
    Route::get(
        'reports/asset_maintenances',
        [ 'as' => 'reports/asset_maintenances', 'uses' => 'ReportsController@getAssetMaintenancesReport' ]
    );
    Route::get(
        'reports/export/asset_maintenances',
        [
            'as'   => 'reports/export/asset_maintenances',
            'uses' => 'ReportsController@exportAssetMaintenancesReport'
        ]
    );
    Route::get(
        'reports/licenses',
        [ 'as' => 'reports/licenses', 'uses' => 'ReportsController@getLicenseReport' ]
    );
    Route::get(
        'reports/export/licenses',
        [ 'as' => 'reports/export/licenses', 'uses' => 'ReportsController@exportLicenseReport' ]
    );
  

    Route::get('reports/accessories', [ 'as' => 'reports/accessories', 'uses' => 'ReportsController@getAccessoryReport' ]);
    Route::get(
        'reports/export/accessories',
        [ 'as' => 'reports/export/accessories', 'uses' => 'ReportsController@exportAccessoryReport' ]
    );
    Route::get('reports/custom', [ 'as' => 'reports/custom', 'uses' => 'ReportsController@getCustomReport' ]);
    Route::post('reports/custom', 'ReportsController@postCustom');

    Route::get(
        'reports/activity',
        [ 'as' => 'reports.activity', 'uses' => 'ReportsController@getActivityReport' ]
    );

    Route::post('reports/activity', 'ReportsController@postActivityReport');



    Route::get(
        'reports/unaccepted_assets',
        [ 'as' => 'reports/unaccepted_assets', 'uses' => 'ReportsController@getAssetAcceptanceReport' ]
    );
    Route::get(
        'reports/export/unaccepted_assets',
        [ 'as' => 'reports/export/unaccepted_assets', 'uses' => 'ReportsController@exportAssetAcceptanceReport' ]
    );
});

Route::get(
    'auth/signin',
    ['uses' => 'Auth\LoginController@legacyAuthRedirect' ]
);




/*
|--------------------------------------------------------------------------
| Setup Routes
|--------------------------------------------------------------------------
|
|
|
*/
Route::group([ 'prefix' => 'setup', 'middleware' => 'web'], function () {
    Route::get(
        'user',
        [
        'as'  => 'setup.user',
        'uses' => 'SettingsController@getSetupUser' ]
    );

    Route::post(
        'user',
        [
        'as'  => 'setup.user.save',
        'uses' => 'SettingsController@postSaveFirstAdmin' ]
    );


    Route::get(
        'migrate',
        [
        'as'  => 'setup.migrate',
        'uses' => 'SettingsController@getSetupMigrate' ]
    );

    Route::get(
        'done',
        [
        'as'  => 'setup.done',
        'uses' => 'SettingsController@getSetupDone' ]
    );

    Route::get(
        'mailtest',
        [
        'as'  => 'setup.mailtest',
        'uses' => 'SettingsController@ajaxTestEmail' ]
    );


    Route::get(
        '/',
        [
        'as'  => 'setup',
        'uses' => 'SettingsController@getSetupIndex' ]
    );

});

Route::get(
    'two-factor-enroll',
    [
        'as' => 'two-factor-enroll',
        'middleware' => ['web'],
        'uses' => 'Auth\LoginController@getTwoFactorEnroll' ]
);

Route::get(
    'two-factor',
    [
        'as' => 'two-factor',
        'middleware' => ['web'],
        'uses' => 'Auth\LoginController@getTwoFactorAuth' ]
);

Route::post(
    'two-factor',
    [
        'as' => 'two-factor',
        'middleware' => ['web'],
        'uses' => 'Auth\LoginController@postTwoFactorAuth' ]
);

Route::get(
    '/',
    [
    'as' => 'home',
    'middleware' => ['auth'],
    'uses' => 'DashboardController@getIndex' ]
);



Route::group(['middleware' => 'web'], function () {
    //Route::auth();

    // new added 28/5/2021
    Route::get(
        ' landing',
        [
            'as' => 'landing',
            'middleware' => ['web'],
            'uses' => 'Auth\RegisterController@landingpage' ]
    );

    // Route::get('/', function() {
    //     return view('landing_page');
    // });

    // end add

    Route::get(
        'login',
        [
            'as' => 'login',
            'middleware' => ['web'],
            'uses' => 'Auth\LoginController@showLoginForm' ]
    );

    Route::post(
        'login',
        [
            'as' => 'login',
            'middleware' => ['web'],
            'uses' => 'Auth\LoginController@login' ]
    );

    Route::get(
        'logout',
        [
            'as' => 'logout',
            'uses' => 'Auth\LoginController@logout' ]
    );

    //  new Add by Farez

    Route::get(
        'register',
        [
            'as' => 'register',
            'middleware' => ['web'],
            'uses' => 'Auth\RegisterController@create' ]
    );

    Route::post(
        'register',
        [
            'as' => 'register',
            'middleware' => ['web'],
            'uses' => 'Auth\RegisterController@store' ]
    );

    
    //fullcalender

    // Route::get('/fullcalendareventmaster','FullCalendarEventMasterController@index');

    // Route::post('/fullcalendareventmaster/create','FullCalendarEventMasterController@create');

    // Route::post('/fullcalendareventmaster/update','FullCalendarEventMasterController@update');

    // Route::post('/fullcalendareventmaster/delete','FullCalendarEventMasterController@destroy');

        Route::get('/full_calender', 'FullCalenderController@index');

    Route::post('full_calender/action', 'FullCalenderController@action');



    // Route::get(
    //     'verify',
    //     [
    //         'as' => 'verify',
    //         'middleware' => ['web'],
    //         'uses' => 'Auth\RegisterController@verify' ]
    // );
    
    Route::get('/verify', [ 'as' => 'verify', 'uses' => 'Auth\RegisterController@verifyUser']);
    



});

Auth::routes();

Route::get('/health', [ 'as' => 'health', 'uses' => 'HealthController@get']);

    // Added by Fikri

Route::get('/project-file-download',['as' => 'project download', 'uses' => 'DownloadController@download_project']);

Route::get('/implementation-file-download',['as' => 'implementation download', 'uses' => 'DownloadController@download_implementation']);

Route::get('/task-file-download',['as' => 'task download', 'uses' => 'DownloadController@download_task']);

Route::get('/subtask-file-download',['as' => 'subtask download', 'uses' => 'DownloadController@download_subtask']);

Route::get('/do-file-download',['as' => 'do download', 'uses' => 'DownloadController@download_do']);

Route::get('/po-file-download',['as' => 'po download', 'uses' => 'DownloadController@download_po']);

Route::get('/sd-file-download',['as' => 'sd download', 'uses' => 'DownloadController@download_sd']);

Route::get('/subtaskDO-file-download',['as' => 'subtask do download', 'uses' => 'DownloadController@download_subtask_do']);

Route::get('/subtaskPO-file-download',['as' => 'subtask po download', 'uses' => 'DownloadController@download_subtask_po']);

Route::get('/subtaskSD-file-download',['as' => 'subtask sd download', 'uses' => 'DownloadController@download_subtask_sd']);

Route::get('/bom-file-download',['as' => 'bom download', 'uses' => 'DownloadController@download_bom']);

Route::get('/access_level_2', 'AccessLevel2Controller@index')->name('access_level_2')->middleware('access_level_2');

Route::get('/access_level_3', 'AccessLevel3Controller@index')->name('access_level_3')->middleware('access_level_3');

Route::get('/access_level_4', 'AccessLevel4Controller@index')->name('access_level_4')->middleware('access_level_4');

