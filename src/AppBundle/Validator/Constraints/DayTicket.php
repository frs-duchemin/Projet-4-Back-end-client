<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class DayTicket extends Constraint
{
    public $message = 'booking.halfday';
}
