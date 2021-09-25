<?php

namespace App\Policies;

class RolePolicy extends SnipePermissionsPolicy
{
    protected function columnName()
    {
        return 'Roles';
    }
}
