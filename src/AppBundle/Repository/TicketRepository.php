<?php

namespace AppBundle\Repository;

/**
 * TicketRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TicketRepository extends \Doctrine\ORM\EntityRepository
{
    public function getNumberOfTicketsPerDay($visitDate) {
        $queryBuilder = $this->createQueryBuilder('t')
            ->select('COUNT(t)')
            ->join('t.booking', 'b')
            ->where('b.visitDate = :visitDate')
            ->setParameter('visitDate', $visitDate)
            ->getQuery()
            ->getSingleScalarResult();

        return $queryBuilder;
    }
}