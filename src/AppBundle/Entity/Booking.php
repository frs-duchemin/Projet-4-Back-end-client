<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Validator\Constraints as LouvreAssert;

/**
 * Booking
 *
 * @ORM\Table(name="booking")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BookingRepository")
 */
class Booking
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
    * @var \DateTime
    *
    * @ORM\Column(name="visit_date", type="datetime")
    * @Assert\NotBlank(message="booking.visitDate.notblank")
    * @Assert\DateTime()
    * @LouvreAssert\DisableTuesday
    * @LouvreAssert\DisableHoliday
    * @Assert\GreaterThanOrEqual("today")
    */
    private $visitDate;

/**
* @var \DateTime
*
* @ORM\Column(name="booking_date", type="datetime")
 * @Assert\DateTime()
 * @Assert\GreaterThanOrEqual(
 *      "today",
 *      message = "booking.date"
 * )
 *
*/
    private $bookingDate;



    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     * @Assert\Email(
     *     message = "booking.email"
     * )
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=255)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", nullable=true)
     */
    private $token;


    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Ticket", mappedBy="booking", cascade={"persist", "remove"}, fetch="EAGER")
     * @Assert\Valid
     * @LouvreAssert\TicketsNumber(message="booking.number")
     */
    private $tickets;

    public function __construct()
    {
        $this->tickets = new ArrayCollection();
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


    /**
     * Set totalMount
     *
     * @param integer $totalMount
     *
     * @return Booking
     */
    public function setTotalMount($totalMount)
    {
        $this->totalMount = $totalMount;

        return $this;
    }


    /**
     * Get totalMount
     *
     * @return integer
     */
    public function getTotalMount()
    {
        $total = 0;
        foreach ($this->tickets as $ticket) {
            $total += $ticket->ticketPrice();
        }

        return $total;
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

    /**
     * Set token
     *
     * @param string $token
     *
     * @return Booking
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }
}
