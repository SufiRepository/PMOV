<?php

return array(

    'does_not_exist' => 'Client does not exist.',


    'create' => array(
        'error'   => 'Client was not created, please try again.',
        'success' => 'Client created successfully.'
    ),

    'update' => array(
        'error'   => 'Client was not updated, please try again',
        'success' => 'Client updated successfully.'
    ),

    'delete' => array(
        'confirm'   => 'Are you sure you wish to delete this Client?',
        'error'   => 'There was an issue deleting the Client. Please try again.',
        'success' => 'Client was deleted successfully.',
        'assoc_assets'	 => 'This Client is currently associated with :asset_count asset(s) and cannot be deleted. Please update your assets to no longer reference this supplier and try again. ',
        'assoc_licenses'	 => 'This Client is currently associated with :licenses_count licences(s) and cannot be deleted. Please update your licenses to no longer reference this supplier and try again. ',
        'assoc_maintenances'	 => 'This Client is currently associated with :asset_maintenances_count asset maintenances(s) and cannot be deleted. Please update your asset maintenances to no longer reference this supplier and try again. ',
    )

);
