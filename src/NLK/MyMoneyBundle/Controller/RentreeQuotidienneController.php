<?php

namespace NLK\MyMoneyBundle\Controller;

use NLK\MyMoneyBundle\Entity\RentreeQuotidienne;
use NLK\MyMoneyBundle\Form\Type\RentreeQuotidienneType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RentreeQuotidienneController extends Controller
{

    public function addAction(Request $request)
    {

    	$rentreeQuotidienne = new RentreeQuotidienne();

    	$formRentreeQuotidienne   = $this->get('form.factory')->create(RentreeQuotidienneType::class, $rentreeQuotidienne);

    	if ($request->isMethod('POST') && $formRentreeQuotidienne->handleRequest($request)->isValid()) {

    		$usr= $this->get('security.token_storage')->getToken()->getUser();
    		$rentreeQuotidienne->setUser($usr);

      		$em = $this->getDoctrine()->getManager();
      		$em->persist($rentreeQuotidienne);
      		$em->flush();

      		$request->getSession()->getFlashBag()->add('notice', 'Rentrée quotidienne bien enregistrée.');
            
            return $this->redirectToRoute('nlk_my_money_home', array(
                'annee' => $rentreeQuotidienne->getDate()->format('Y'),
                'mois'  => $rentreeQuotidienne->getDate()->format('m')
            ));
    	
    	}

    	return $this->render('NLKMyMoneyBundle:RentreeQuotidienne:add.html.twig', array(
    		'formRentreeQuotidienne' => $formRentreeQuotidienne->createView(),
    	));
    }

    public function editAction(RentreeQuotidienne $rentreeQuotidienne, Request $request)
    {
        $user= $this->get('security.token_storage')->getToken()->getUser();

        if ( $rentreeQuotidienne->getUser() == $user )
        {
            $formRentreeQuotidienne = $this->get('form.factory')->create(RentreeQuotidienneType::class, $rentreeQuotidienne);

            if ($request->isMethod('POST') && $formRentreeQuotidienne->handleRequest($request)->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'Dépense bien modifiée.');

                return $this->redirectToRoute('nlk_my_money_home', array(
                    'annee' => $rentreeQuotidienne->getDate()->format('Y'),
                    'mois'  => $rentreeQuotidienne->getDate()->format('m')
                ));

            }

            return $this->render('NLKMyMoneyBundle:RentreeQuotidienne:edit.html.twig', array(
                'rentreeQuotidienne' => $rentreeQuotidienne,
                'formRentreeQuotidienne'   => $formRentreeQuotidienne->createView(),
            ));
        }
        else
        {
            return $this->redirectToRoute('nlk_my_money_home');
        }
    }

    public function duplicateAction(RentreeQuotidienne $rentreeQuotidienne, Request $request)
    {
        $user= $this->get('security.token_storage')->getToken()->getUser();

        if( $rentreeQuotidienne->getUser() == $user)
        {
            
            $rentreeQuotidienneDupliquee = new RentreeQuotidienne();

            $rentreeQuotidienneDupliquee->setUser($rentreeQuotidienne->getUser());
            $rentreeQuotidienneDupliquee->setCategorie($rentreeQuotidienne->getCategorie());
            $rentreeQuotidienneDupliquee->setMontant($rentreeQuotidienne->getMontant());
            $rentreeQuotidienneDupliquee->setName($rentreeQuotidienne->getName());

            $formRentreeQuotidienne = $this->get('form.factory')->create(RentreeQuotidienneType::class, $rentreeQuotidienneDupliquee);

            if ($request->isMethod('POST') && $formRentreeQuotidienne->handleRequest($request)->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($rentreeQuotidienneDupliquee);               
                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'Rentrée bien dupliquée.');
                
                return $this->redirectToRoute('nlk_my_money_home', array(
                    'annee' => $rentreeQuotidienneDupliquee->getDate()->format('Y'),
                    'mois'  => $rentreeQuotidienneDupliquee->getDate()->format('m')
                ));
                
            }

            return $this->render('NLKMyMoneyBundle:RentreeQuotidienne:duplicate.html.twig', array(
          'rentreeQuotidienneDupliquee' => $rentreeQuotidienneDupliquee,
          'formRentreeQuotidienne'   => $formRentreeQuotidienne->createView(),
          ));
        }
        else
        {
            return $this->redirectToRoute('nlk_my_money_home');
        }
    }
}
