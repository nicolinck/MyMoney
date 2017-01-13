<?php

namespace NLK\MyMoneyBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * DepenseQuotidienne
 *
 * @ORM\Table(name="depenseQuotidienne")
 * @ORM\Entity(repositoryClass="NLK\MyMoneyBundle\Repository\DepenseQuotidienneRepository")
 */
class DepenseQuotidienne extends Depense
{

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

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

    public function __construct()
    {
        $this->date = new \Datetime();
    }

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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return DepenseQuotidienne
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set commun
     *
     * @param boolean $commun
     *
     * @return DepenseQuotidienne
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
     * @return DepenseQuotidienne
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
     * @return DepenseQuotidienne
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
