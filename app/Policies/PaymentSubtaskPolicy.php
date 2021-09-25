<?php

namespace App\Policies;

class PaymentSubtaskPolicy extends SnipePermissionsPolicy
{
    protected function columnName()
    {
        return 'paymentsubtask';
    }
}
