<?php

namespace NLK\MyMoneyBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * RentreeQuotidienne
 *
 * @ORM\Table(name="rentreeQuotidienne")
 * @ORM\Entity(repositoryClass="NLK\MyMoneyBundle\Repository\RentreeQuotidienneRepository")
 */
class RentreeQuotidienne extends Rentree
{

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    public function __construct()
    {
        $this->date = new \Datetime();
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return RentreeQuotidienne
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

}
