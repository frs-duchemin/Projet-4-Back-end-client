<?php



namespace AppBundle\Manager;

use AppBundle\Entity\Booking;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class SessionBooking
{
    private $em;
    private $session;

    /**
     * GestionBooking constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em, Session $session)
    {
        $this->em = $em;
        $this->session = $session;
    }

    /**
     * @param Booking $booking
     */
    public function setSessionBooking(Booking $booking)
    {
        $this->session->set('booking', $booking);
    }

    /**
     * @return mixed|null
     */
    public function getSessionBooking()
    {
        if ($this->session->get('booking')) {
            $booking = $this->session->get('booking');
        } else {
            return null;
        }
        return $booking;
    }

    /**
     * @param Booking $booking
     */
    public function saveBooking(Booking $booking)
    {
        $this->em->persist($booking);
        $this->em->flush();
        $this->session->remove('booking');
    }
}

