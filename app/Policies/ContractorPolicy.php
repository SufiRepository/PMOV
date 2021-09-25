<?php

namespace App\Policies;

class ContractorPolicy extends SnipePermissionsPolicy
{
    protected function columnName()
    {
        return 'Contractors';
    }
}
