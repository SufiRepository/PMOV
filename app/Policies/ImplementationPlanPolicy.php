<?php

namespace App\Policies;

class ImplementationPlanPolicy extends SnipePermissionsPolicy
{
    protected function columnName()
    {
        return 'implementationplans';
    }
}
