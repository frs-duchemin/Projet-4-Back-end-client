<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Validator\Constraints as LouvreAssert;

/**
 * Ticket
 *
 * @ORM\Table(name="ticket")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TicketRepository")
 */
class Ticket
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
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     * @Assert\NotBlank(message="ticket.name.notblank")
     * @Assert\Length(min=2, minMessage="ticket.name.min")
     * @Assert\Length(max=50, maxMessage="ticket.firstname.max")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255)
     * @Assert\NotBlank(message="ticket.name.notblank")
     * @Assert\Length(min=2, minMessage="ticket.firstname.min")
     * @Assert\Length(max=50, maxMessage="ticket.firstname.max")
     */
    private $firstname;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthDate", type="date")
     * @Assert\DateTime()
     */
    private $birthDate;

    /**
     * @var
     * @ORM\Column(name="country", type="string")
     * @Assert\Country(message = "ticket.country")
     */
    private $country;

    /**
     * @var
     * @ORM\Column(name="ticket_type", type="string")
     * @LouvreAssert\DayTicket
     */
    private $ticketType;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Tarif", inversedBy="tickets")
     * @ORM\JoinColumn(name="tarif_id", referencedColumnName="id", nullable=false)
     */

    private $tarif;


    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Booking", inversedBy="tickets")
     * @ORM\JoinColumn(name="booking_id", referencedColumnName="id", nullable=false)
     */

    private $booking;


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
     * Set name
     *
     * @param string $name
     *
     * @return Ticket
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return Ticket
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set birthDate
     *
     * @param \DateTime $birthDate
     *
     * @return Ticket
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Get birthDate
     *
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }



    /**
     * Set Booking
     *
     * @param \AppBundle\Entity\Booking $booking
     *
     * @return TIcket
     */
    public function setBooking(\AppBundle\Entity\Booking $booking)
    {
        $this->booking = $booking;
        return $this;
    }
    /**
     * Get booking
     *
     * @return \AppBundle\Entity\Booking
     */
    public function getBooking()
    {
        return $this->booking;
    }



    /**
     * Set ticketType
     *
     * @param string $ticketType
     *
     * @return Ticket
     */
    public function setTicketType($ticketType)
    {
        $this->ticketType = $ticketType;

        return $this;
    }

    /**
     * Get ticketType
     *
     * @return string
     */
    public function getTicketType()
    {
        return $this->ticketType;
    }

    /**
     * Set tarif
     *
     * @param \AppBundle\Entity\Tarif $tarif
     *
     * @return Ticket
     */
    public function setTarif(\AppBundle\Entity\Tarif $tarif)
    {
        $this->tarif = $tarif;
        $tarif->addTicket($this);
        return $this;
    }

    /**
     * Get tarif
     *
     * @return \AppBundle\Entity\Tarif
     */
    public function getTarif()
    {
        return $this->tarif;
    }

    public function ticketPrice()
{
    if ($this->getTicketType() == 'demi-journee') {
        $prix = $this->getTarif()->getPrice() / 2;
        return $prix;
    } else {
        return $this->getTarif()->getPrice();
    }
}


}
