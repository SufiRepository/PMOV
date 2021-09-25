<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;

class RegisterPolicy extends SnipePermissionsPolicy
{
    protected function columnName()
    {
        return 'register';
    }
}

