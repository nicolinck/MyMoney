<?php

namespace NLK\MyMoneyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Exercice
 *
 * @ORM\Table(name="exercice")
 * @ORM\Entity(repositoryClass="NLK\MyMoneyBundle\Repository\ExerciceRepository")
 */
class Exercice
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
     * @var int
     *
     * @ORM\Column(name="annee", type="smallint")
     */
    private $annee;

    /**
     * @var int
     *
     * @ORM\Column(name="mois", type="smallint")
     */
    private $mois;

    public function getFirstDay()
    {
        $annee = $this->getAnnee();
        $mois = $this->getMois();

        $firstDay = new \Datetime($annee.'-'.$mois.'-01');

        return $firstDay;
    }

    public function getLastDay()
    {
        return $this->getFirstday()->format('Y-m-t');
    }

    public function getMonthName()
    {
        switch($this->getMois())
        {
            case 1:
                return 'Janvier';
                break;
            case 2:
                return 'Février';
                break;
            case 3:
                return 'Mars';
                break;
            case 4:
                return 'Avril';
                break;
            case 5:
                return 'Mai';
                break;
            case 6:
                return 'Juin';
                break;
            case 7:
                return 'Juillet';
                break;
            case 8:
                return 'Aout';
                break;
            case 9:
                return 'Septembre';
                break;
            case 10:
                return 'Octobre';
                break;
            case 11:
                return 'Novembre';
                break;
            case 12:
                return 'Décembre';
                break;
            default:
                return '';
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
     * Set annee
     *
     * @param integer $annee
     *
     * @return Exercice
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * Get annee
     *
     * @return int
     */
    public function getAnnee()
    {
        return $this->annee;
    }

    /**
     * Set mois
     *
     * @param integer $mois
     *
     * @return Exercice
     */
    public function setMois($mois)
    {
        $this->mois = $mois;

        return $this;
    }

    /**
     * Get mois
     *
     * @return int
     */
    public function getMois()
    {
        return $this->mois;
    }
}
