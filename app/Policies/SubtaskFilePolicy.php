<?php

namespace App\Policies;

class SubtaskFilePolicy extends SnipePermissionsPolicy
{
    protected function columnName()
    {
        return 'subtaskuploads';
    }
}
