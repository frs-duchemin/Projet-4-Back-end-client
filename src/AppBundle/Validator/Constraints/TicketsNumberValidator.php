<?php
namespace AppBundle\Validator\Constraints;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class TicketsNumberValidator extends ConstraintValidator
{
    private $em;

    public function __construct(EntityManager $em)  {

        $this->em =$em;
    }
    public function validate($value, Constraint $constraint)
    {
        $formValues = $this->context->getRoot()->getData();
        $visitDate = $formValues->getVisitDate();
        $dayTicketsNumber = $this->em->getRepository('AppBundle:Ticket')->getNumberOfTicketsPerDay($visitDate);
        $totalTicketsNumber = count($value) + $dayTicketsNumber;
        if ( $totalTicketsNumber >= 3) {
                $remainingTicketsNumber = $totalTicketsNumber - 3;
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ visitDate }}', $visitDate->format('d-m-Y'))
                    ->setParameter('{{ RemainingTicketsNumber }}', $remainingTicketsNumber)
                    ->addViolation();
        }
    }
}