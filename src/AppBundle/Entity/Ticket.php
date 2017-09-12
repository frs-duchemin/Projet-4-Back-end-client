<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Ticket
 */
class Ticket
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $firstname;

    /**
     * @var \DateTime
     */
    private $birthDate;

    /**
     * @var string
     */
    private $country;

    /**
     * @var string
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
    * Set booking
    *
    * @param \AppBundle\Entity\Booking $booking
    *
    * @return Ticket
    */
    public function setBooking(\Frs\LouvreBundle\Entity\Commande $booking)
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
    * Set tarif
    *
    * @param \AppBundle\Entity\Tarif $tarif
    *
    * @return Ticket
    */
    public function setTarif(\AppBundle\Entity\Tarif $tarif)
        {
            $this->tarif = $tarif;

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
                    $price = $this->getTarif()->getPrice() / 2;
                    return $price;
                    } else {
                        return $this->getTarif()->getPrice();
                    }
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
     * Set country
     *
     * @param string $country
     *
     * @return Ticket
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
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
}
