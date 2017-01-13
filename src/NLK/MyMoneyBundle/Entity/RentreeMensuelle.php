<?php

namespace NLK\MyMoneyBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * RentreeMensuelle
 *
 * @ORM\Table(name="rentreeMensuelle")
 * @ORM\Entity(repositoryClass="NLK\MyMoneyBundle\Repository\RentreeMensuelleRepository")
 */
class RentreeMensuelle extends Rentree
{

   	/**
     * @ORM\ManyToOne(targetEntity="NLK\MyMoneyBundle\Entity\Exercice")
     * @ORM\JoinColumn(nullable=false)
     */
    private $exercice;

    /**
     * Set exercice
     *
     * @param \NLK\MyMoneyBundle\Entity\Exercice $exercice
     *
     * @return RentreeMensuelle
     */
    public function setExercice(\NLK\MyMoneyBundle\Entity\Exercice $exercice)
    {
        $this->exercice = $exercice;

        return $this;
    }

    /**
     * Get exercice
     *
     * @return \NLK\MyMoneyBundle\Entity\Exercice
     */
    public function getExercice()
    {
        return $this->exercice;
    }

}
