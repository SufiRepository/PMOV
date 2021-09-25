<?php

return array(

    'does_not_exist' => 'Subtask does not exist.',


    'create' => array(
        'error'   => 'Subtask was not created, please try again.',
        'success' => 'Subtask created successfully.'
    ),

    'update' => array(
        'error'   => 'Subtask was not updated, please try again',
        'success' => 'Subtask updated successfully.'
    ),

    'delete' => array(
        'confirm'   => 'Are you sure you wish to delete this Subtask?',
        'error'   => 'There was an issue deleting the Subtask. Please try again.',
        'success' => 'Subtask was deleted successfully.',
        'assoc_assets'	 => 'This Subtask is currently associated with :asset_count asset(s) and cannot be deleted. Please update your assets to no longer reference this Subtask and try again. ',
        'assoc_licenses'	 => 'This Subtask is currently associated with :licenses_count licences(s) and cannot be deleted. Please update your licenses to no longer reference this Subtask and try again. ',
        'assoc_maintenances'	 => 'This Subtask is currently associated with :asset_maintenances_count asset maintenances(s) and cannot be deleted. Please update your asset maintenances to no longer reference this Subtask and try again. ',
    )

);
