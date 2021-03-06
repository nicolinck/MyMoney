<?php

namespace NLK\MyMoneyBundle\Repository;

/**
 * CategorieDepenseRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategorieCreditRepository extends \Doctrine\ORM\EntityRepository
{
	public function orderedFindAll()
	{
		$qb = $this->createQueryBuilder('a');
  		$qb->orderBy('a.name', 'ASC')
  		;

  		return $qb
    	->getQuery()
    	->getResult()
  		;
	}
}
