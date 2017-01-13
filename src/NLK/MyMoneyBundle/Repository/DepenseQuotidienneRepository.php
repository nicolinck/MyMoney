<?php

namespace NLK\MyMoneyBundle\Repository;

/**
 * DepenseQuotidienneRepository
 */
class DepenseQuotidienneRepository extends \Doctrine\ORM\EntityRepository
{
	public function findBilanMensuel($exercice)
	{

        $qb = $this->createQueryBuilder('a');

  		$qb
            ->andWhere('a.date BETWEEN :start AND :end')
                ->setParameter('start', $exercice->getFirstDay())
                ->setParameter('end',   $exercice->getLastDay())
            ->andWhere('a.deleted = 0')
     		->orderBy('a.date', 'ASC')
            ->addOrderBy('a.id', 'ASC')

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
            ->andWhere('a.date BETWEEN :start AND :end')
                ->setParameter('start', $exercice->getFirstDay())
                ->setParameter('end',   $exercice->getLastDay())
          ->andWhere('a.deleted = 0')
          ->andWhere('a.commun = 1')
            ->orderBy('a.date', 'ASC')
        ;
        return $qb
            ->getQuery()
            ->getResult()
        ;
    }

    public function findTotalDepensesQuotidiennes($exercice,$user)
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
