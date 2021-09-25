<?php

namespace App\Policies;

class PaymentTaskPolicy extends SnipePermissionsPolicy
{
    protected function columnName()
    {
        return 'paymenttask';
    }
}
