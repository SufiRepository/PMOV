<?php

namespace App\Policies;

class StatusTaskPolicy extends SnipePermissionsPolicy
{
    protected function columnName()
    {
        return 'statustasks';
    }
}
