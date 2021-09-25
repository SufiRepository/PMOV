<?php

return array(

    'does_not_exist' => 'Task does not exist.',


    'create' => array(
        'error'   => 'Task was not created, please try again.',
        'success' => 'Task  created successfully.'
    ),

    'update' => array(
        'error'   => 'Task  was not updated, please try again',
        'success' => 'Task  updated successfully.'
    ),

    'delete' => array(
        'confirm'   => 'Are you sure you wish to delete this Task ?',
        'error'   => 'There was an issue deleting the Task . Please try again.',
        'success' => ' Task was deleted successfully.',
        'assoc_assets'	 => 'This Task  is currently associated with :asset_count asset(s) and cannot be deleted. Please update your assets to no longer reference this Task and try again. ',
        'assoc_licenses'	 => 'This Task  is currently associated with :licenses_count licences(s) and cannot be deleted. Please update your licenses to no longer reference this Task and try again. ',
        'assoc_maintenances'	 => 'This Task  is currently associated with :asset_maintenances_count asset maintenances(s) and cannot be deleted. Please update your asset maintenances to no longer reference this task and try again. ',
    )

);
