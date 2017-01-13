<?php

namespace NLK\MyMoneyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rentree
 *
 * @ORM\Table(name="rentree")
 * @ORM\Entity(repositoryClass="NLK\MyMoneyBundle\Repository\RentreeRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="typeRentree", type="string")
 * @ORM\DiscriminatorMap({"Q" = "RentreeQuotidienne", "M" = "RentreeMensuelle", "A" = "RentreeAmmortie"})
 */
abstract class Rentree
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=63)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="montant", type="decimal", precision=8, scale=2)
     */
    protected $montant;

    /**
     * @ORM\ManyToOne(targetEntity="NLK\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="NLK\MyMoneyBundle\Entity\CategorieCredit")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $categorie;

    /**
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="boolean")
     */
    protected $deleted = false;
    
    /**
     * @var \Datetime
     *
     * @ORM\Column(name="dateSuppression", type="datetime", nullable=true)
     */
    protected $dateSuppression;


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
     * @return Depense
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
     * Set montant
     *
     * @param string $montant
     *
     * @return Depense
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get montant
     *
     * @return string
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * Set user
     *
     * @param \NLK\UserBundle\Entity\User $user
     *
     * @return Depense
     */
    public function setUser(\NLK\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \NLK\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set categorie
     *
     * @param \NLK\MyMoneyBundle\Entity\CategorieDebit $categorie
     *
     * @return Rentree
     */
    public function setCategorie(\NLK\MyMoneyBundle\Entity\CategorieCredit $categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return \NLK\MyMoneyBundle\Entity\CategorieCredit
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     *
     * @return Rentree
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set dateSuppression
     *
     * @param \DateTime $dateSuppression
     *
     * @return Rentree
     */
    public function setDateSuppression($dateSuppression)
    {
        $this->dateSuppression = $dateSuppression;

        return $this;
    }

    /**
     * Get dateSuppression
     *
     * @return \DateTime
     */
    public function getDateSuppression()
    {
        return $this->dateSuppression;
    }
}
