<?php

return array(

    'does_not_exist' => 'Team member does not exist.',


    'create' => array(
        'error'   => 'Team member was not created, please try again.',
        'success' => 'Team member created successfully.'
    ),

    'update' => array(
        'error'   => 'Team member was not updated, please try again',
        'success' => 'Team member updated successfully.'
    ),

    'delete' => array(
        'confirm'   => 'Are you sure you wish to delete this Team member?',
        'error'   => 'There was an issue deleting the Team member. Please try again.',
        'success' => 'Team member was deleted successfully.',
        'assoc_assets'	 => 'This Team member is currently associated with :asset_count asset(s) and cannot be deleted. Please update your assets to no longer reference this Team member and try again. ',
        'assoc_licenses'	 => 'This Team member is currently associated with :licenses_count licences(s) and cannot be deleted. Please update your licenses to no longer reference this Team member and try again. ',
        'assoc_maintenances'	 => 'This Team member is currently associated with :asset_maintenances_count asset maintenances(s) and cannot be deleted. Please update your asset maintenances to no longer reference this Team member and try again. ',
    )

);
