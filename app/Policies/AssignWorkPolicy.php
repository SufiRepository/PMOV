<?php

namespace App\Policies;

class AssignworkPolicy extends CheckoutablePermissionsPolicy
{
    protected function columnName()
    {
        return 'assignworks';
    }
}
