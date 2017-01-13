<?php

namespace NLK\MyMoneyBundle\Controller;

use NLK\MyMoneyBundle\Entity\DepenseAmmortie;
use NLK\MyMoneyBundle\Form\Type\DepenseAmmortieType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DepenseAmmortieController extends Controller
{
    public function addAction(Request $request)
    {

    	$depenseAmmortie = new DepenseAmmortie();

    	$formDepenseAmmortie   = $this->get('form.factory')->create(DepenseAmmortieType::class, $depenseAmmortie);

    	if ($request->isMethod('POST') && $formDepenseAmmortie->handleRequest($request)->isValid()) {

    		$usr= $this->get('security.token_storage')->getToken()->getUser();
    		$depenseAmmortie->setUser($usr);

    		$em = $this->getDoctrine()->getManager();
    		$em->persist($depenseAmmortie);
    		$em->flush();

    		$request->getSession()->getFlashBag()->add('notice', 'Dépense ammortie bien enregistrée.');
            
    		return $this->redirectToRoute('nlk_my_money_ammortissements_view');
    	
    	}

    	return $this->render('NLKMyMoneyBundle:DepenseAmmortie:add.html.twig', array(
    		'formDepenseAmmortie' => $formDepenseAmmortie->createView(),
    	));
    }

    public function editAction(DepenseAmmortie $depenseAmmortie, Request $request)
    {
        $user= $this->get('security.token_storage')->getToken()->getUser();

        if ( $depenseAmmortie->getUser() == $user )
        {
            $formDepenseAmmortie = $this->get('form.factory')->create(DepenseAmmortieType::class, $depenseAmmortie);

            if ($request->isMethod('POST') && $formDepenseAmmortie->handleRequest($request)->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $request->getSession()->getFlashBag()->add('notice', 'Dépense bien modifiée.');
                return $this->redirectToRoute('nlk_my_money_ammortissements_view');
            }

            return $this->render('NLKMyMoneyBundle:DepenseAmmortie:edit.html.twig', array(
          'depenseAmmortie' => $depenseAmmortie,
          'formDepenseAmmortie'   => $formDepenseAmmortie->createView(),
          ));
        }
        else
        {
            return $this->redirectToRoute('nlk_my_money_home');
        }

    }
}
