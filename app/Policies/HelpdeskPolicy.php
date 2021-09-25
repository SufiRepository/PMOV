<?php

namespace App\Policies;

class HelpdeskPolicy extends SnipePermissionsPolicy
{
    protected function columnName()
    {
        return 'helpdesks';
    }
}
