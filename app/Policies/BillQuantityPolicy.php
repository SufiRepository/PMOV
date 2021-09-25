<?php

namespace App\Policies;

class BillQuantityPolicy extends SnipePermissionsPolicy
{
    protected function columnName()
    {
        return 'billquantities';
    }
}
