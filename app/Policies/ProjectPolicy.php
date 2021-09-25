<?php

namespace App\Policies;

class ProjectPolicy extends SnipePermissionsPolicy
{
    protected function columnName()
    {
        return 'project';
    }
}
