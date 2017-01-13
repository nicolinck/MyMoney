<?php

namespace NLK\MyMoneyBundle\Controller;

use NLK\MyMoneyBundle\Entity\DepenseMensuelle;
use NLK\MyMoneyBundle\Form\Type\DepenseMensuelleType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DepenseMensuelleController extends Controller
{

    public function addAction(Request $request)
    {

    	$depenseMensuelle = new DepenseMensuelle();

        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('NLKMyMoneyBundle:Exercice')
        ;

        $exerciceCourant = $repository->findExerciceCourant();

        $depenseMensuelle->setExercice($exerciceCourant);

    	$formDepenseMensuelle   = $this->get('form.factory')->create(DepenseMensuelleType::class, $depenseMensuelle);

    	if ($request->isMethod('POST') && $formDepenseMensuelle->handleRequest($request)->isValid()) {

    		$usr= $this->get('security.token_storage')->getToken()->getUser();
    		$depenseMensuelle->setUser($usr);

    		$em = $this->getDoctrine()->getManager();
    		$em->persist($depenseMensuelle);
    		$em->flush();

    		$request->getSession()->getFlashBag()->add('notice', 'Dépense mensuelle bien enregistrée.');
        
    		return $this->redirectToRoute('nlk_my_money_home', array(
                'annee' => $depenseMensuelle->getExercice()->getAnnee(),
                'mois'  => $depenseMensuelle->getExercice()->getMois()
            ));
    	
    	}

    	return $this->render('NLKMyMoneyBundle:DepenseMensuelle:add.html.twig', array(
    		'formDepenseMensuelle' => $formDepenseMensuelle->createView(),
    	));
    }

    public function editAction(DepenseMensuelle $depenseMensuelle, Request $request)
    {
        $user= $this->get('security.token_storage')->getToken()->getUser();

        if ( $depenseMensuelle->getUser() == $user)
        {
            $formDepenseMensuelle = $this->get('form.factory')->create(DepenseMensuelleType::class, $depenseMensuelle);

            if ($request->isMethod('POST') && $formDepenseMensuelle->handleRequest($request)->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $request->getSession()->getFlashBag()->add('notice', 'Dépense bien modifiée.');
                
                return $this->redirectToRoute('nlk_my_money_home', array(
                        'annee' => $depenseMensuelle->getExercice()->getAnnee(),
                        'mois'  => $depenseMensuelle->getExercice()->getMois()
                ));
            }

            return $this->render('NLKMyMoneyBundle:DepenseMensuelle:edit.html.twig', array(
          'depenseMensuelle' => $depenseMensuelle,
          'formDepenseMensuelle'   => $formDepenseMensuelle->createView(),
          ));           
        }
        else
        {
            return $this->redirectToRoute('nlk_my_money_home');
        }

    }

    public function duplicateAction(DepenseMensuelle $depenseMensuelle, Request $request)
    {
        $user= $this->get('security.token_storage')->getToken()->getUser();

        if( $depenseMensuelle->getUser() == $user)
        {
            
            $exerciceCourant = $this->getDoctrine()
                ->getManager()
                ->getRepository('NLKMyMoneyBundle:Exercice')
                ->findExerciceCourant()
            ;

            $depenseMensuelleDupliquee = new DepenseMensuelle();

            $depenseMensuelleDupliquee->setUser($depenseMensuelle->getUser());
            $depenseMensuelleDupliquee->setCategorie($depenseMensuelle->getCategorie());
            $depenseMensuelleDupliquee->setMontant($depenseMensuelle->getMontant());
            $depenseMensuelleDupliquee->setName($depenseMensuelle->getName());
            $depenseMensuelleDupliquee->setExercice($exerciceCourant);
            $depenseMensuelleDupliquee->setCommun($depenseMensuelle->getCommun());
            $depenseMensuelleDupliquee->setPerso($depenseMensuelle->getPerso());
            $depenseMensuelleDupliquee->setAutre($depenseMensuelle->getAutre());

            $formDepenseMensuelle = $this->get('form.factory')->create(DepenseMensuelleType::class, $depenseMensuelleDupliquee);

            if ($request->isMethod('POST') && $formDepenseMensuelle->handleRequest($request)->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($depenseMensuelleDupliquee);
                $em->flush();
                $request->getSession()->getFlashBag()->add('notice', 'Dépense bien dupliquée.');
                return $this->redirectToRoute('nlk_my_money_home', array(
                    'annee' => $depenseMensuelleDupliquee->getExercice()->getAnnee(),
                    'mois'  => $depenseMensuelleDupliquee->getExercice()->getMois()
                ));
            }

            return $this->render('NLKMyMoneyBundle:DepenseMensuelle:duplicate.html.twig', array(
          'depenseMensuelleDupliquee' => $depenseMensuelleDupliquee,
          'formDepenseMensuelle'   => $formDepenseMensuelle->createView(),
          ));
        }
        else
        {
            return $this->redirectToRoute('nlk_my_money_home');
        }
    }
}
