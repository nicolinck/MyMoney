<?php

namespace NLK\MyMoneyBundle\Entity;

use Doctrine\ORM\EntityManager;
use NLK\UserBundle\Entity\User;

class BilanMensuel
{
	private $user;

	private $exercice;

	private $depensesQuotidiennes = array();

	private $depensesMensuelles = array();

	private $depensesAmmorties = array();

	private $rentreesQuotidiennes = array();

	private $rentreesMensuelles = array();

	private $rentreesAmmorties = array();

	public function __construct(EntityManager $em,Exercice $exercice,User $user)
	{
		$this->setUser($user);
		$this->setExercice($exercice);

		$renQ = $em
				->getRepository('NLKMyMoneyBundle:RentreeQuotidienne')
            	->findBilanMensuel($exercice,$user)
       	;
		$this->setRenQ($renQ);

		$renM = $em
				->getRepository('NLKMyMoneyBundle:RentreeMensuelle')
            	->findBy(
            		array('user' => $user, 'exercice' => $exercice, 'deleted' => 0),
            		array('montant' => 'desc')
      	);
       	$this->setRenM($renM);

       	$renA = $em
            	->getRepository('NLKMyMoneyBundle:RentreeAmmortie')
            	->findByUserAndExercice($user, $exercice)
       	;
		$this->setRenA($renA);

		$depQ = $em
				->getRepository('NLKMyMoneyBundle:DepenseQuotidienne')
            	->findBilanMensuel($exercice)
       	;
       	$this->setdepQ($depQ);

       	$depM = $em
				->getRepository('NLKMyMoneyBundle:DepenseMensuelle')
            	->findBy(
            		array('exercice' => $exercice, 'deleted' => 0),
            		array('montant' => 'desc')
      	);
       	$this->setdepM($depM);

       	$depA = $em
            	->getRepository('NLKMyMoneyBundle:DepenseAmmortie')
            	->findByUserAndExercice($user, $exercice)
       	;
		$this->setDepA($depA);
	}

	public function getUserDepQ()
	{
		$userDepQ = array();

		foreach($this->getDepQ() as $depQ)
		{
			if( $depQ->getUser() == $this->getUser())
			{
				$userDepQ[] = $depQ;
			}
		}

		return $userDepQ;
	}

	public function getUserDepM()
	{
		$userDepM = array();

		foreach($this->getDepM() as $depM)
		{
			if( $depM->getUser() == $this->getUser())
			{
				$userDepM[] = $depM;
			}
		}

		return $userDepM;
	}

	public function getUserRenQ()
	{
		$userRenQ = array();

		foreach($this->getRenQ() as $renQ)
		{
			if( $renQ->getUser() == $this->getUser())
			{
				$userRenQ[] = $renQ;
			}
		}

		return $userRenQ;
	}

	public function getUserRenM()
	{
		$userRenM = array();

		foreach($this->getRenM() as $renM)
		{
			if( $renM->getUser() == $this->getUser())
			{
				$userRenM[] = $renM;
			}
		}

		return $userRenM;
	}

	public function getTotalRenQ()
	{
		$totalRenQ = 0;

		foreach($this->getRenQ() as $renQ)
		{
			$totalRenQ += $renQ->getMontant();
		}

		return $totalRenQ;
	}

	public function getTotalRenM()
	{
		$totalRenM = 0;

		foreach($this->getRenM() as $renM)
		{
			$totalRenM += $renM->getMontant();
		}

		return $totalRenM;
	}

	public function getTotalRenA()
	{
		$totalRenA = 0;

        foreach ($this->getRenA() as $renA)
        {
            $totalRenA += $renA->getMontantMensuel($this->getExercice());
        }

		return $totalRenA;
	}

	public function getTotalDepQ()
	{
		$totalDepQ = 0;

		foreach($this->getUserDepQ() as $depQ)
		{
			$totalDepQ += $depQ->getMontant();
		}

		return $totalDepQ;
	}

	public function getTotalDepM()
	{
		$totalDepM = 0;

		foreach($this->getUserDepM() as $depM)
		{
			$totalDepM += $depM->getMontant();
		}

		return $totalDepM;
	}

	public function getTotalDepA()
	{
		$totalDepA = 0;

        foreach ($this->getDepA() as $depA)
        {
            $totalDepA += $depA->getMontantMensuel($this->getExercice());
        }

		return $totalDepA;
	}

	public function getTotalDep()
	{
		$totalDep = 0;

		$totalDep += $this->getTotalDepA() + $this->getTotalDepM() + $this->getTotalDepQ();

		return $totalDep;
	}

	public function getTotalRen()
	{
		$totalRen = 0;

		$totalRen  += $this->getTotalRenA() + $this->getTotalRenM() + $this->getTotalRenQ();

		return $totalRen ;
	}

	public function getRegul()
	{
		$depensesPerso = 0;
		$depensesAutre = 0;

		foreach ($this->getDepQ() as $depQ)
		{
			if( $depQ->getCommun() )
			{
				if( $depQ->getUser() == $this->getUser())
				{
					$depensesPerso += $depQ->getRegul();
				}
				else
				{
					$depensesAutre += $depQ->getRegul();
				}
			}
		}

		foreach ($this->getDepM() as $depM)
		{
			if( $depM->getCommun() )
			{
				if( $depM->getUser() == $this->getUser())
				{
					$depensesPerso += $depM->getRegul();
				}
				else
				{
					$depensesAutre += $depM->getRegul();
				}
			}
		}

		$regul = ($depensesPerso - $depensesAutre) / 2 ;

		return $regul;

	}


	public function setUser(\NLK\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setExercice(\NLK\MyMoneyBundle\Entity\Exercice $exercice)
    {
        $this->exercice = $exercice;

        return $this;
    }

    public function getExercice()
    {
        return $this->exercice;
    }

    public function setDepQ(Array $depQ) 
    {
    	$this->depensesQuotidiennes = $depQ;

    	return $this;
    }

    public function getDepQ()
    {
    	return $this->depensesQuotidiennes;
    }

   	public function setDepM(Array $depM) 
    {
    	$this->depensesMensuelles = $depM;

    	return $this;
    }

    public function getDepM()
    {
    	return $this->depensesMensuelles;
    }

   	public function setDepA(Array $depA) 
    {
    	$this->depensesAmmorties = $depA;

    	return $this;
    }

    public function getDepA()
    {
    	return $this->depensesAmmorties;
    }

   	public function setRenQ(Array $renQ) 
    {
    	$this->rentreesQuotidiennes = $renQ;

    	return $this;
    }

    public function getRenQ()
    {
    	return $this->rentreesQuotidiennes;
    }

   	public function setRenM(Array $renM) 
    {
    	$this->rentreesMensuelles = $renM;

    	return $this;
    }

    public function getRenM()
    {
    	return $this->rentreesMensuelles;
    }

   	public function setRenA(Array $renA) 
    {
    	$this->rentreesAmmorties = $renA;

    	return $this;
    }

    public function getRenA()
    {
    	return $this->rentreesAmmorties;
    }

}
