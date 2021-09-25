<?php

namespace App\Policies;

class BillingPolicy extends SnipePermissionsPolicy
{
    protected function columnName()
    {
        return 'billing';
    }
}
