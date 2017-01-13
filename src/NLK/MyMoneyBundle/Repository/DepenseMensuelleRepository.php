<?php

namespace NLK\MyMoneyBundle\Repository;

/**
 * DepenseMensuelleRepository
 */
class DepenseMensuelleRepository extends \Doctrine\ORM\EntityRepository
{
	public function findBilanMensuel($exercice,$user)
	{

        $qb = $this->createQueryBuilder('a');

  		$qb
            ->andWhere('a.exercice = :exercice')
                ->setParameter('exercice', $exercice)
       		->andWhere('a.user = :user')
       			->setParameter('user', $user)
            ->andWhere('a.deleted = 0')
     		->orderBy('a.montant', 'DESC')
     	;
  		return $qb
    		->getQuery()
    		->getResult()
  		;
	}

    public function findDepensesCommunes($exercice)
    {

        $qb = $this->createQueryBuilder('a');

        $qb
            ->andWhere('a.exercice = :exercice')
                ->setParameter('exercice', $exercice)
            ->andWhere('a.deleted = 0')
            ->andWhere('a.commun = 1')
            ->orderBy('a.montant', 'DESC')
        ;
        return $qb
            ->getQuery()
            ->getResult()
        ;
    }

    public function findTotalDepensesMensuelles($exercice,$user)
    {

        $qb = $this->createQueryBuilder('a');

        $qb
            ->select('SUM(a.montant) as total')
            ->andWhere('a.exercice = :exercice')
                ->setParameter('exercice', $exercice)
            ->andWhere('a.user = :user')
                ->setParameter('user', $user)
            ->andWhere('a.deleted = 0')
        ;
        return $qb
            ->getQuery()
            ->getSingleResult()
        ;
    }
}
