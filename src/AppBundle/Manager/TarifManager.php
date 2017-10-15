<?php
namespace AppBundle\Manager;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Booking;
use AppBundle\Entity\Ticket;

/**
 * Created by PhpStorm.
 * User: Frs
 * Date: 04/04/2017
 * Time: 17:23
 */
class TarifManager
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function listTarifs()
    {
        $tarifs = $this->em->getRepository('AppBundle:Tarif')->findAll();
        return $tarifs;
    }

    public function tarifFromAge(\DateTime $date)
    {
        $age = $date->diff(new \DateTime())->y;
        if ($age < 4) {
            $tarif = 'gratuit';
        } elseif ($age >= 4 && $age < 12) {
            $tarif = 'enfant';
        } elseif ($age >= 60 ) {
            $tarif = 'senior';
        } else {
            $tarif = 'normal';
        }
        return $this->em->getRepository('AppBundle:Tarif')->findOneByTarifName($tarif);
    }
}
