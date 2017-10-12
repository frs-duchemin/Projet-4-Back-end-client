<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class DayTicketValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if ($value == 'journee') {
            $now = new \DateTime('now');
            $formValues = $this->context->getRoot()->getData();
            $visitDate = $formValues->getVisitDate()->format('Y-m-d');
            $time = $now->format('h');
            if ($now->format('Y-m-d') == $visitDate && $time >= '7') {
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ visitDate }}', $visitDate)
                    ->addViolation();
            }
        }
    }
}