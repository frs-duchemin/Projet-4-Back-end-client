<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */

class DisableHoliday extends Constraint
{
    public $message = 'Le musée est fermé ce jour.';
}