<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Booking
 */
class Booking
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $visitDate;

    /**
     * @var \DateTime
     */
    private $bookingDate;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $code;


    /**
         * @ORM\OneToMany(targetEntity="AppBundle\Entity\Ticket", mappedBy="booking", cascade={"persist", "remove"})
         */
        private $tickets;

        public function __construct()
        {
            $this->tickets = new ArrayCollection();
        }

        /**
             * Add ticket
             *
             * @param \AppBundle\Entity\Ticket $ticket
             *
             * @return Booking
             */
            public function addTicket(\AppBundle\Entity\Ticket $ticket)
            {
                $this->tickets[] = $ticket;
                return $this;
            }
            /**
             * Remove ticket
             *
             * @param \AppBundle\Entity\Ticket $ticket
             */
            public function removeTicket(\AppBundle\Entity\Ticket $ticket)
            {
                $this->tickets->removeElement($ticket);
            }
            /**
             * Get tickets
             *
             * @return \Doctrine\Common\Collections\Collection
             */
            public function getTickets()
            {
                return $this->tickets;
            }


            public function getTotalMount()
            {
                $total = 0;
                foreach ($this->tickets as $ticket) {
                    $total += $ticket->ticketPrice();
                }

                return $total;
            }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set visitDate
     *
     * @param \DateTime $visitDate
     *
     * @return Booking
     */
    public function setVisitDate($visitDate)
    {
        $this->visitDate = $visitDate;

        return $this;
    }

    /**
     * Get visitDate
     *
     * @return \DateTime
     */
    public function getVisitDate()
    {
        return $this->visitDate;
    }

    /**
     * Set bookingDate
     *
     * @param \DateTime $bookingDate
     *
     * @return Booking
     */
    public function setBookingDate($bookingDate)
    {
        $this->bookingDate = $bookingDate;

        return $this;
    }

    /**
     * Get bookingDate
     *
     * @return \DateTime
     */
    public function getBookingDate()
    {
        return $this->bookingDate;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Booking
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return Booking
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }
}
