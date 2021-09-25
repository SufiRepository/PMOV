<?php

namespace App\Policies;

class SubtaskPolicy extends SnipePermissionsPolicy
{
    protected function columnName()
    {
        return 'subtasks';
    }
}
