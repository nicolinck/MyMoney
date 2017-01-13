<?php

namespace NLK\MyMoneyBundle\Controller;

use NLK\MyMoneyBundle\Entity\Depense;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DepenseController extends Controller
{
    public function deleteAction(Depense $depense)
    {
        $em = $this->getDoctrine()->getManager();

        $date = date_create(date('Y-m-d H:i:s'));

        $depense->setDeleted(true);
        $depense->setDateSuppression($date);

        $em->flush();
            
        return $this->redirectToRoute('nlk_my_money_home');
  }
}
