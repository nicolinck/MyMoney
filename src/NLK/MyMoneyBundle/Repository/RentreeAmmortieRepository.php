<?php

namespace NLK\MyMoneyBundle\Repository;

/**
 * RentreeAmmortieRepository
 */
class RentreeAmmortieRepository extends \Doctrine\ORM\EntityRepository
{
	public function findTotalByUser($user)
    {

        $qb = $this->createQueryBuilder('a');

        $qb
            ->andWhere('a.user = :user')
                ->setParameter('user', $user)
            ->andWhere('a.deleted = 0')
        ;
        return $qb
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByUserAndExercice($user, $exercice)
    {

        $qb = $this->createQueryBuilder('a');

        $qb
            ->innerJoin('a.exerciceDebut', 'exerciceDebut')
            ->innerJoin('a.exerciceFin', 'exerciceFin')
            ->andWhere('exerciceDebut.id <= :id_exercice')
            ->andWhere('exerciceFin.id >= :id_exercice')
                ->setParameter('id_exercice', $exercice->getId())
            ->andWhere('a.user = :user')
                ->setParameter('user', $user)
            ->andWhere('a.deleted = 0')
        ;
        return $qb
            ->getQuery()
            ->getResult()
        ;
    }
}
