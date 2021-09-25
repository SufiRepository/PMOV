<?php

namespace App\Policies;

class ClientPolicy extends SnipePermissionsPolicy
{
    protected function columnName()
    {
        return 'clients';
    }
}
