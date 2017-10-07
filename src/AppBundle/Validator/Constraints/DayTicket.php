<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class DayTicket extends Constraint
{
    public $message = 'Le billet pour "{{ visitDate }}" ne peut-être réservé que après 14h';
}