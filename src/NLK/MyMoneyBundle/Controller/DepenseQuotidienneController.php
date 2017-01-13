<?php

namespace NLK\MyMoneyBundle\Controller;

use NLK\MyMoneyBundle\Entity\DepenseQuotidienne;
use NLK\MyMoneyBundle\Form\Type\DepenseQuotidienneType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DepenseQuotidienneController extends Controller
{
    public function addAction(Request $request)
    {

    	$depenseQuotidienne = new DepenseQuotidienne();

    	$formDepenseQuotidienne   = $this->get('form.factory')->create(DepenseQuotidienneType::class, $depenseQuotidienne);

    	if ($request->isMethod('POST') && $formDepenseQuotidienne->handleRequest($request)->isValid()) {

            $usr= $this->get('security.token_storage')->getToken()->getUser();
  		    $depenseQuotidienne->setUser($usr);

  		    $em = $this->getDoctrine()->getManager();
  		    $em->persist($depenseQuotidienne);
  		    $em->flush();

    		$request->getSession()->getFlashBag()->add('notice', 'Dépense quotidienne bien enregistrée.');
            
            return $this->redirectToRoute('nlk_my_money_home', array(
                'annee' => $depenseQuotidienne->getDate()->format('Y'),
                'mois'  => $depenseQuotidienne->getDate()->format('m')
            ));
    	
    	}

    	return $this->render('NLKMyMoneyBundle:DepenseQuotidienne:add.html.twig', array(
    		'formDepenseQuotidienne' => $formDepenseQuotidienne->createView(),
    	));
    }

    public function editAction(DepenseQuotidienne $depenseQuotidienne, Request $request)
    {
        $user= $this->get('security.token_storage')->getToken()->getUser();

        if( $depenseQuotidienne->getUser() == $user)
        {
            $formDepenseQuotidienne = $this->get('form.factory')->create(DepenseQuotidienneType::class, $depenseQuotidienne);

            if ($request->isMethod('POST') && $formDepenseQuotidienne->handleRequest($request)->isValid()) 
            {

                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $request->getSession()->getFlashBag()->add('notice', 'Dépense bien modifiée.');

                return $this->redirectToRoute('nlk_my_money_home', array(
                    'annee' => $depenseQuotidienne->getDate()->format('Y'),
                    'mois'  => $depenseQuotidienne->getDate()->format('m')
                ));
                
            }

            return $this->render('NLKMyMoneyBundle:DepenseQuotidienne:edit.html.twig', array(
          'depenseQuotidienne' => $depenseQuotidienne,
          'formDepenseQuotidienne'   => $formDepenseQuotidienne->createView(),
          ));
        }
        else
        {
            return $this->redirectToRoute('nlk_my_money_home');
        }
    }

    public function duplicateAction(DepenseQuotidienne $depenseQuotidienne, Request $request)
    {
        $user= $this->get('security.token_storage')->getToken()->getUser();

        if( $depenseQuotidienne->getUser() == $user)
        {
            
            $depenseQuotidienneDupliquee = new DepenseQuotidienne();

            $depenseQuotidienneDupliquee->setUser($depenseQuotidienne->getUser());
            $depenseQuotidienneDupliquee->setCategorie($depenseQuotidienne->getCategorie());
            $depenseQuotidienneDupliquee->setMontant($depenseQuotidienne->getMontant());
            $depenseQuotidienneDupliquee->setName($depenseQuotidienne->getName());
            $depenseQuotidienneDupliquee->setCommun($depenseQuotidienne->getCommun());
            $depenseQuotidienneDupliquee->setPerso($depenseQuotidienne->getPerso());
            $depenseQuotidienneDupliquee->setAutre($depenseQuotidienne->getAutre());

            $formDepenseQuotidienne = $this->get('form.factory')->create(DepenseQuotidienneType::class, $depenseQuotidienneDupliquee);

            if ($request->isMethod('POST') && $formDepenseQuotidienne->handleRequest($request)->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($depenseQuotidienneDupliquee);
                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'Dépense bien dupliquée.');

                return $this->redirectToRoute('nlk_my_money_home', array(
                    'annee' => $depenseQuotidienneDupliquee->getDate()->format('Y'),
                    'mois'  => $depenseQuotidienneDupliquee->getDate()->format('m')
                ));
            
            }

            return $this->render('NLKMyMoneyBundle:DepenseQuotidienne:duplicate.html.twig', array(
          'depenseQuotidienneDupliquee' => $depenseQuotidienneDupliquee,
          'formDepenseQuotidienne'   => $formDepenseQuotidienne->createView(),
          ));
        }
        else
        {
            return $this->redirectToRoute('nlk_my_money_home');
        }
    }


}
