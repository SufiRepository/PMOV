<?php

namespace App\Policies;

class FilePolicy extends SnipePermissionsPolicy
{
    protected function columnName()
    {
        return 'projectuploads';
    }
}
