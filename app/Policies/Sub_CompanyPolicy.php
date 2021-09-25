<?php

namespace App\Policies;

class Sub_CompanyPolicy extends SnipePermissionsPolicy
{
    protected function columnName()
    {
        return 'sub_companies';
    }
}
