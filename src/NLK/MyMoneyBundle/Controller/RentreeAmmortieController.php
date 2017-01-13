<?php

namespace NLK\MyMoneyBundle\Controller;

use NLK\MyMoneyBundle\Entity\RentreeAmmortie;
use NLK\MyMoneyBundle\Form\Type\RentreeAmmortieType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RentreeAmmortieController extends Controller
{

    public function addAction(Request $request)
    {

    	$rentreeAmmortie = new RentreeAmmortie();

    	$formRentreeAmmortie   = $this->get('form.factory')->create(RentreeAmmortieType::class, $rentreeAmmortie);

    	if ($request->isMethod('POST') && $formRentreeAmmortie->handleRequest($request)->isValid()) {

    		$usr= $this->get('security.token_storage')->getToken()->getUser();
    		$rentreeAmmortie->setUser($usr);

      		$em = $this->getDoctrine()->getManager();
      		$em->persist($rentreeAmmortie);
      		$em->flush();

      		$request->getSession()->getFlashBag()->add('notice', 'Rentrée ammortie bien enregistrée.');

            return $this->redirectToRoute('nlk_my_money_ammortissements_view');

    	}

    	return $this->render('NLKMyMoneyBundle:RentreeAmmortie:add.html.twig', array(
    		'formRentreeAmmortie' => $formRentreeAmmortie->createView(),
    	));
    }

    public function editAction(RentreeAmmortie $rentreeAmmortie, Request $request)
    {
        $user= $this->get('security.token_storage')->getToken()->getUser();

        if ( $rentreeAmmortie->getUser() == $user )
        {
            $formRentreeAmmortie = $this->get('form.factory')->create(RentreeAmmortieType::class, $rentreeAmmortie);

            if ($request->isMethod('POST') && $formRentreeAmmortie->handleRequest($request)->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'Dépense bien modifiée.');

                return $this->redirectToRoute('nlk_my_money_ammortissements_view');
            }

            return $this->render('NLKMyMoneyBundle:RentreeAmmortie:edit.html.twig', array(
          'RentreeAmmortie' => $rentreeAmmortie,
          'formRentreeAmmortie'   => $formRentreeAmmortie->createView(),
          ));
        }
        else
        {
            return $this->redirectToRoute('nlk_my_money_home');
        }
    }
}
