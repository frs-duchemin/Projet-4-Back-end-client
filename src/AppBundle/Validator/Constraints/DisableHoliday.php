<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */

class DisableHoliday extends Constraint
{
    public $message = 'booking.holiday';
}