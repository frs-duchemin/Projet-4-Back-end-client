<?php
/**
 * Created by PhpStorm.
 * User: Frs
 * Date: 13/10/2017
 * Time: 21:54
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Entity
 */
class TarifTranslation

{
    use ORMBehaviors\Translatable\Translation;

    /**
     * @var string
     *
     * @ORM\Column(name="tarif_name", type="string", length=255)
     */
    private $tarifName;

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
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;



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


}
