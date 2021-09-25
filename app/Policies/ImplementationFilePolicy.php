<?php

namespace App\Policies;

class ImplementationFilePolicy extends SnipePermissionsPolicy
{
    protected function columnName()
    {
        return 'implementationuploads';
    }
}
