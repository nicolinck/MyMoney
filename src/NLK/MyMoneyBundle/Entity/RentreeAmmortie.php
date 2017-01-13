<?php

namespace NLK\MyMoneyBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * RentreeAmmortie
 *
 * @ORM\Table(name="rentreeAmmortie")
 * @ORM\Entity(repositoryClass="NLK\MyMoneyBundle\Repository\RentreeAmmortieRepository")
 */
class RentreeAmmortie extends Rentree
{

   	/**
     * @ORM\ManyToOne(targetEntity="NLK\MyMoneyBundle\Entity\Exercice")
     * @ORM\JoinColumn(nullable=false)
     */
    private $exerciceDebut;

    /**
     * @ORM\ManyToOne(targetEntity="NLK\MyMoneyBundle\Entity\Exercice")
     * @ORM\JoinColumn(nullable=false)
     */
    private $exerciceFin;

    public function getNbMois()
    {
        return $this->getExerciceFin()->getId() - $this->getExerciceDebut()->getId() + 1 ;
    }


    public function getMontantMensuel($exercice)
    {
        if( $this->isConcerned($exercice) ){
            $montant = $this->getMontant();
            $nbMois = $this->getNbMois();
            return $montant / $nbMois;
        }
        else {
            return 0;
        }
    }

    public function isConcerned($exercice)
    {
        if( ($exercice->getId() >= $this->getExerciceDebut()->getId()) && ($exercice->getId() <= $this->getExerciceFin()->getId())) {
            return true;
        }
        else {
            return false;
        }
    }
    /**
     * Set exerciceDebut
     *
     * @param \NLK\MyMoneyBundle\Entity\Exercice $exerciceDebut
     *
     * @return RentreeAmmortie
     */
    public function setExerciceDebut(\NLK\MyMoneyBundle\Entity\Exercice $exerciceDebut)
    {
        $this->exerciceDebut = $exerciceDebut;

        return $this;
    }

    /**
     * Get exerciceDebut
     *
     * @return \NLK\MyMoneyBundle\Entity\Exercice
     */
    public function getExerciceDebut()
    {
        return $this->exerciceDebut;
    }

    /**
     * Set exerciceFin
     *
     * @param \NLK\MyMoneyBundle\Entity\Exercice $exerciceFin
     *
     * @return RentreeAmmortie
     */
    public function setExerciceFin(\NLK\MyMoneyBundle\Entity\Exercice $exerciceFin)
    {
        $this->exerciceFin = $exerciceFin;

        return $this;
    }

    /**
     * Get exerciceFin
     *
     * @return \NLK\MyMoneyBundle\Entity\Exercice
     */
    public function getExerciceFin()
    {
        return $this->exerciceFin;
    }
}
