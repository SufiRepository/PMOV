<?php

return array(

    'does_not_exist' => 'Assignwork does not exist.',


    'create' => array(
        'error'   => 'Assignwork was not created, please try again.',
        'success' => 'Assignwork created successfully.'
    ),

    'update' => array(
        'error'   => 'Assignwork was not updated, please try again',
        'success' => 'Assignwork updated successfully.'
    ),

    'delete' => array(
        'confirm'   => 'Are you sure you wish to delete this Assignwork?',
        'error'   => 'There was an issue deleting the Assignwork. Please try again.',
        'success' => 'Assignwork was deleted successfully.',
        'assoc_assets'	 => 'This Assignwork is currently associated with :asset_count asset(s) and cannot be deleted. Please update your assets to no longer reference this supplier and try again. ',
        'assoc_licenses'	 => 'This Assignwork is currently associated with :licenses_count licences(s) and cannot be deleted. Please update your licenses to no longer reference this supplier and try again. ',
        'assoc_maintenances'	 => 'This Assignwork is currently associated with :asset_maintenances_count asset maintenances(s) and cannot be deleted. Please update your asset maintenances to no longer reference this supplier and try again. ',
    )

);
