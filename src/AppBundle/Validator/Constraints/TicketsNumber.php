<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class TicketsNumber extends Constraint
{
    public $message = 'Désolé, il ne reste que {{ RemainingTicketsNumber }}  billet(s) pour le {{ visitDate }}';

    public function validatedBy()
    {
        return 'tickets_number';
    }
}