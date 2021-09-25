<?php

return array(

    'does_not_exist' => 'Contractor does not exist.',


    'create' => array(
        'error'   => 'Contractor was not created, please try again.',
        'success' => 'Contractor created successfully.'
    ),

    'update' => array(
        'error'   => 'Contractor was not updated, please try again',
        'success' => 'Contractor updated successfully.'
    ),

    'delete' => array(
        'confirm'   => 'Are you sure you wish to delete this Contractor?',
        'error'   => 'There was an issue deleting the Contractor. Please try again.',
        'success' => 'Contractor was deleted successfully.',
        'assoc_assets'	 => 'This Contractor is currently associated with :asset_count asset(s) and cannot be deleted. Please update your assets to no longer reference this Contractor and try again. ',
        'assoc_licenses'	 => 'This Contractor is currently associated with :licenses_count licences(s) and cannot be deleted. Please update your licenses to no longer reference this Contractor and try again. ',
        'assoc_maintenances'	 => 'This Contractor is currently associated with :asset_maintenances_count asset maintenances(s) and cannot be deleted. Please update your asset maintenances to no longer reference this Contractor and try again. ',
    )

);
