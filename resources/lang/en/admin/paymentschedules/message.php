<?php

return array(

    'does_not_exist' => 'Payment does not exist.',


    'create' => array(
        'error'   => 'Payment was not created, please try again.',
        'success' => 'paymePaymentntschedules created successfully.'
    ),

    'update' => array(
        'error'   => 'Payment was not updated, please try again',
        'success' => 'Payment updated successfully.'
    ),

    'delete' => array(
        'confirm'   => 'Are you sure you wish to delete this Payment?',
        'error'   => 'There was an issue deleting the Payment. Please try again.',
        'success' => 'Payment was deleted successfully.',
        'assoc_assets'	 => 'This Payment is currently associated with :asset_count asset(s) and cannot be deleted. Please update your assets to no longer reference this Payment and try again. ',
        'assoc_licenses'	 => 'This Payment is currently associated with :licenses_count licences(s) and cannot be deleted. Please update your licenses to no longer reference this Payment and try again. ',
        'assoc_maintenances'	 => 'This Payment is currently associated with :asset_maintenances_count asset maintenances(s) and cannot be deleted. Please update your asset maintenances to no longer reference this Payment and try again. ',
    )

);
