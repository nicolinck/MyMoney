<?php

namespace NLK\MyMoneyBundle\Repository;

/**
 * RentreeQuotidienneRepository
 */
class RentreeQuotidienneRepository extends \Doctrine\ORM\EntityRepository
{
	public function findBilanMensuel($exercice,$user)
	{

        $qb = $this->createQueryBuilder('a');

  		$qb
            ->andWhere('a.date BETWEEN :start AND :end')
                ->setParameter('start', $exercice->getFirstDay())
                ->setParameter('end',   $exercice->getLastDay())
       		->andWhere('a.user = :user')
       			->setParameter('user', $user)
          ->andWhere('a.deleted = 0')
     		->orderBy('a.date', 'ASC')
     		->orderBy('a.id', 'ASC')
     	;
  		return $qb
    		->getQuery()
    		->getResult()
  		;
	}

    public function findTotalRentreesQuotidiennes($exercice,$user)
    {

        $qb = $this->createQueryBuilder('a');

        $qb
            ->select('SUM(a.montant) as total')
            ->andWhere('a.date BETWEEN :start AND :end')
                ->setParameter('start', $exercice->getFirstDay())
                ->setParameter('end',   $exercice->getLastDay())
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
