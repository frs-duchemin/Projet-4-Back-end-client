<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class DisableTuesdayValidator extends ConstraintValidator
{
    public function validate($dateTime, Constraint $constraint)
    {
        if (!$dateTime instanceof \DateTime){
            $dateTime = new \DateTime($dateTime);
        }
        $timestamp = $dateTime->getTimestamp();
        $date = strftime('%A %d %B', $timestamp);
        $tuesday = explode(" ", $date);
        if ($tuesday[0] === "Tuesday") {
            $this->context->addViolation($constraint->message);
        }
    }
}