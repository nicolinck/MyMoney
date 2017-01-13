<?php

namespace NLK\MyMoneyBundle\Controller;

use NLK\MyMoneyBundle\Entity\Rentree;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RentreeController extends Controller
{
    public function deleteAction(Rentree $rentree)
    {
        $em = $this->getDoctrine()->getManager();

        $date = date_create(date('Y-m-d H:i:s'));

        $rentree->setDeleted(true);
        $rentree->setDateSuppression($date);

        $em->flush();
            
        return $this->redirectToRoute('nlk_my_money_home');
  }
}
