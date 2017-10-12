<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class TicketsNumber extends Constraint
{
    public $message = 'booking.number';

    public function validatedBy()
    {
        return 'tickets_number';
    }
}