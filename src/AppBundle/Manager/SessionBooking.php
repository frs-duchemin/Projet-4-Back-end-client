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
        $this->session->set('tmpbooking', $booking);
    }

    /**
     * @return mixed|null
     */
    public function getSessionBooking()
    {
        if ($this->session->get('tmpbooking')) {
            $booking = $this->session->get('tmpbooking');
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
        foreach ($booking->getTickets() as $ticket){
        $tarif = $this->em->getRepository('AppBundle:Tarif')->find($ticket->getTarif()->getId());
        $ticket->setTarif($tarif);
        }

        $this->em->persist($booking);
        $this->em->flush();
        $this->session->remove('tmpbooking');
    }
}

