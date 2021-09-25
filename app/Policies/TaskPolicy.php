<?php

namespace App\Policies;

class TaskPolicy extends SnipePermissionsPolicy
{
    protected function columnName()
    {
        return 'tasks';
    }
}
