<?php

namespace App\Policies;

class TypeprojectPolicy extends SnipePermissionsPolicy
{
    protected function columnName()
    {
        return 'typeprojects';
    }
}
