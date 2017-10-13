<?php
namespace AppBundle\Validator\Constraints;
use Symfony\Component\Validator\Constraint;
/**
 * @Annotation
 */
class DisableTuesday extends Constraint
{
    public $message = 'booking.tuesday';
}
