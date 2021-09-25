<?php

namespace App\Policies;

class WorkPolicy extends SnipePermissionsPolicy
{
    protected function columnName()
    {
        return 'works';
    }
}
