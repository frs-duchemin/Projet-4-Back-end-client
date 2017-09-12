<?php

namespace AppBundle\Entity;

/**
 * Tarif
 */
class Tarif
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $tarifName;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $price;

    /**
    * @ORM\OneToMany(targetEntity="AppBundle\Entity\Ticket", mappedBy="tarif", cascade={"persist"})
    */
    private $tickets;


    /**
    * Set tarifValue
    *
    * @param string $tarifValue
    *
    * @return Tarif
    */
    public function setTarifValue($tarifValue)
        {
            $this->tarifValue = $tarifValue;

            return $this;
        }

        /**
         * Get tarifValue
         *
         * @return string
         */
        public function getTarifValue()
        {
            return $this->tarifValue;
        }
        /**
         * Constructor
         */
        public function __construct()
        {
            $this->tickets = new \Doctrine\Common\Collections\ArrayCollection();
        }

        /**
         * Add ticket
         *
         * @param \AppBundle\Entity\Ticket $ticket
         *
         * @return Tarif
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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set tarifName
     *
     * @param string $tarifName
     *
     * @return Tarif
     */
    public function setTarifName($tarifName)
    {
        $this->tarifName = $tarifName;

        return $this;
    }

    /**
     * Get tarifName
     *
     * @return string
     */
    public function getTarifName()
    {
        return $this->tarifName;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Tarif
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Tarif
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }
}
