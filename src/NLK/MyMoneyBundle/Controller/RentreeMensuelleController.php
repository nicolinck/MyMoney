<?php

namespace NLK\MyMoneyBundle\Controller;

use NLK\MyMoneyBundle\Entity\RentreeMensuelle;
use NLK\MyMoneyBundle\Form\Type\RentreeMensuelleType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RentreeMensuelleController extends Controller
{

    public function addAction(Request $request)
    {

    	$rentreeMensuelle = new RentreeMensuelle();

        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('NLKMyMoneyBundle:Exercice')
        ;

        $exerciceCourant = $repository->findExerciceCourant();

        $rentreeMensuelle->setExercice($exerciceCourant);

    	$formRentreeMensuelle   = $this->get('form.factory')->create(RentreeMensuelleType::class, $rentreeMensuelle);

    	if ($request->isMethod('POST') && $formRentreeMensuelle->handleRequest($request)->isValid()) {

    		$usr= $this->get('security.token_storage')->getToken()->getUser();
    		$rentreeMensuelle->setUser($usr);

      		$em = $this->getDoctrine()->getManager();
      		$em->persist($rentreeMensuelle);
      		$em->flush();

      		$request->getSession()->getFlashBag()->add('notice', 'Rentrée mensuelle bien enregistrée.');
            
            return $this->redirectToRoute('nlk_my_money_home', array(
                    'annee' => $rentreeMensuelle->getExercice()->getAnnee(),
                    'mois'  => $rentreeMensuelle->getExercice()->getMois()
            ));
    	}

    	return $this->render('NLKMyMoneyBundle:RentreeMensuelle:add.html.twig', array(
    		'formRentreeMensuelle' => $formRentreeMensuelle->createView(),
    	));
    }

    public function editAction(RentreeMensuelle $rentreeMensuelle, Request $request)
    {
        
        $user= $this->get('security.token_storage')->getToken()->getUser();

        if ( $rentreeMensuelle->getUser() == $user)
        {
            $formRentreeMensuelle = $this->get('form.factory')->create(RentreeMensuelleType::class, $rentreeMensuelle);

            if ($request->isMethod('POST') && $formRentreeMensuelle->handleRequest($request)->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $request->getSession()->getFlashBag()->add('notice', 'Dépense bien modifiée.');
                return $this->redirectToRoute('nlk_my_money_home', array(
                    'annee' => $rentreeMensuelle->getExercice()->getAnnee(),
                    'mois'  => $rentreeMensuelle->getExercice()->getMois()
                ));
            }

            return $this->render('NLKMyMoneyBundle:RentreeMensuelle:edit.html.twig', array(
          'RentreeMensuelle' => $rentreeMensuelle,
          'formRentreeMensuelle'   => $formRentreeMensuelle->createView(),
          ));
        }
        else
        {
            return $this->redirectToRoute('nlk_my_money_home');
        }
    }

    public function duplicateAction(RentreeMensuelle $rentreeMensuelle, Request $request)
    {
        $user= $this->get('security.token_storage')->getToken()->getUser();

        if( $rentreeMensuelle->getUser() == $user)
        {
            
            $exerciceCourant = $this->getDoctrine()
                ->getManager()
                ->getRepository('NLKMyMoneyBundle:Exercice')
                ->findExerciceCourant()
            ;

            $rentreeMensuelleDupliquee = new RentreeMensuelle();

            $rentreeMensuelleDupliquee->setUser($rentreeMensuelle->getUser());
            $rentreeMensuelleDupliquee->setCategorie($rentreeMensuelle->getCategorie());
            $rentreeMensuelleDupliquee->setMontant($rentreeMensuelle->getMontant());
            $rentreeMensuelleDupliquee->setName($rentreeMensuelle->getName());
            $rentreeMensuelleDupliquee->setExercice($exerciceCourant);

            $formRentreeMensuelle = $this->get('form.factory')->create(RentreeMensuelleType::class, $rentreeMensuelleDupliquee);

            if ($request->isMethod('POST') && $formRentreeMensuelle->handleRequest($request)->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($rentreeMensuelleDupliquee);
                $em->flush();
                $request->getSession()->getFlashBag()->add('notice', 'Rentrée bien dupliquée.');
                return $this->redirectToRoute('nlk_my_money_home');
            }

            return $this->render('NLKMyMoneyBundle:RentreeMensuelle:duplicate.html.twig', array(
          'rentreeMensuelleDupliquee' => $rentreeMensuelleDupliquee,
          'formRentreeMensuelle'   => $formRentreeMensuelle->createView(),
          ));
        }
        else
        {
            return $this->redirectToRoute('nlk_my_money_home', array(
                'annee' => $rentreeMensuelleDupliquee->getExercice()->getAnnee(),
                'mois'  => $rentreeMensuelleDupliquee->getExercice()->getMois()
            ));
        }
    }
}
