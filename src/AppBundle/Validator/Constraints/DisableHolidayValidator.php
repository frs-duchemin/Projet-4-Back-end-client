<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class DisableHolidayValidator extends ConstraintValidator

{
    public function validate($dateTime, Constraint $constraint)
    {
        $holidays = ['01-05-2017', '01-11-2017', '25-12-2017'];
        $holiday = [];
        if (!$dateTime instanceof \DateTime){
            $dateTime = new \DateTime($dateTime);
        }
        $timestamp = $dateTime->getTimestamp();
        $date = strftime('%d %B', $timestamp);
        for ($i = 0; $i < count($holidays); $i++) {
            $holiday[$i] = strftime('%d %B', strtotime($holidays[$i]));
        }
        if ($date === $holiday[0] || $date === $holiday[1] || $date === $holiday[2]) {
            $this->context->addViolation($constraint->message);
        }
    }
}