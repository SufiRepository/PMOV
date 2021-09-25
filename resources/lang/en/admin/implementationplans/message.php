<?php

return array(

    'does_not_exist' => 'Project Plan does not exist.',


    'create' => array(
        'error'   => 'Project Plan was not created, please try again.',
        'success' => 'Project Plan created successfully.'
    ),

    'update' => array(
        'error'   => 'Project Plan was not updated, please try again',
        'success' => 'Project Plan updated successfully.'
    ),

    'delete' => array(
        'confirm'   => 'Are you sure you wish to delete this Project Plan?',
        'error'   => 'There was an issue deleting the Project Plan. Please try again.',
        'success' => 'Project Plan was deleted successfully.',
        'assoc_assets'	 => 'This Project Plan is currently associated with :asset_count asset(s) and cannot be deleted. Please update your assets to no longer reference this Task and try again. ',
        'assoc_licenses'	 => 'This Project Plan is currently associated with :licenses_count licences(s) and cannot be deleted. Please update your licenses to no longer reference this Task and try again. ',
        'assoc_maintenances'	 => 'This Project Plan is currently associated with :asset_maintenances_count asset maintenances(s) and cannot be deleted. Please update your asset maintenances to no longer reference this task and try again. ',
    )

);
