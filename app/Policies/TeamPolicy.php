<?php

namespace App\Policies;

class TeamPolicy extends SnipePermissionsPolicy
{
    protected function columnName()
    {
        return 'team';
    }
}