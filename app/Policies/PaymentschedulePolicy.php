<?php

namespace App\Policies;

class PaymentSchedulePolicy extends SnipePermissionsPolicy
{
    protected function columnName()
    {
        return 'paymentschedule';
    }
}
