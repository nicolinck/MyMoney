<?php

namespace NLK\MyMoneyBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * DepenseMensuelle
 *
 * @ORM\Table(name="depenseMensuelle")
 * @ORM\Entity(repositoryClass="NLK\MyMoneyBundle\Repository\DepenseMensuelleRepository")
 */
class DepenseMensuelle extends Depense
{

   	/**
     * @ORM\ManyToOne(targetEntity="NLK\MyMoneyBundle\Entity\Exercice")
     * @ORM\JoinColumn(nullable=false)
     */
    private $exercice;

    /**
     * @var boolean
     *
     * @ORM\Column(name="commun", type="boolean", nullable=true)
     */
    private $commun;

    /**
     * @var string
     *
     * @ORM\Column(name="perso", type="decimal", precision=8, scale=2, nullable=true)
     */
    private $perso;

    /**
     * @var string
     *
     * @ORM\Column(name="autre", type="decimal", precision=8, scale=2, nullable=true)
     */
    private $autre;


    public function getRegul()
    {
        $regul = 0;

        if( $this->getCommun() )
        {
            $regul += $this->getMontant() - $this->getPerso() + $this->getAutre(); 
        }

        return $regul;
    }
    
    /**
     * Set exercice
     *
     * @param \NLK\MyMoneyBundle\Entity\Exercice $exercice
     *
     * @return DepenseMensuelle
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

    /**
     * Set commun
     *
     * @param boolean $commun
     *
     * @return DepenseMensuelle
     */
    public function setCommun($commun)
    {
        $this->commun = $commun;

        return $this;
    }

    /**
     * Get commun
     *
     * @return boolean
     */
    public function getCommun()
    {
        return $this->commun;
    }

    /**
     * Set perso
     *
     * @param string $perso
     *
     * @return DepenseMensuelle
     */
    public function setPerso($perso)
    {
        $this->perso = $perso;

        return $this;
    }

    /**
     * Get perso
     *
     * @return string
     */
    public function getPerso()
    {
        return $this->perso;
    }

    /**
     * Set autre
     *
     * @param string $autre
     *
     * @return DepenseMensuelle
     */
    public function setAutre($autre)
    {
        $this->autre = $autre;

        return $this;
    }

    /**
     * Get autre
     *
     * @return string
     */
    public function getAutre()
    {
        return $this->autre;
    }
}
