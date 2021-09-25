<?php

namespace App\Policies;

class TaskFilePolicy extends SnipePermissionsPolicy
{
    protected function columnName()
    {
        return 'taskuploads';
    }
}
