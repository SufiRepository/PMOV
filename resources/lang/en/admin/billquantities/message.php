<?php

return array(

    'does_not_exist' => 'Bill of Material does not exist.',


    'create' => array(
        'error'   => 'Bill of Material was not created, please try again.',
        'success' => 'Bill of Material created successfully.'
    ),

    'update' => array(
        'error'   => 'Bill of Material was not updated, please try again',
        'success' => 'Bill of Material updated successfully.'
    ),

    'delete' => array(
        'confirm'   => 'Are you sure you wish to delete this Bill of Material?',
        'error'   => 'There was an issue deleting the Bill of Material. Please try again.',
        'success' => 'Bill of Material was deleted successfully.',
        'assoc_assets'	 => 'This Bill of Material is currently associated with :asset_count asset(s) and cannot be deleted. Please update your assets to no longer reference this supplier and try again. ',
        'assoc_licenses'	 => 'This Bill of Material is currently associated with :licenses_count licences(s) and cannot be deleted. Please update your licenses to no longer reference this supplier and try again. ',
        'assoc_maintenances'	 => 'This Bill of Material is currently associated with :asset_maintenances_count asset maintenances(s) and cannot be deleted. Please update your asset maintenances to no longer reference this supplier and try again. ',
    )

);
